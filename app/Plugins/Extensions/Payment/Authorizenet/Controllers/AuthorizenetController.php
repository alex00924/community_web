<?php
namespace App\Plugins\Extensions\Payment\Authorizenet\Controllers;


use App\Http\Controllers\ShopCart;
use App\Models\ShopOrder;
use App\Models\ShopCardTransaction;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Models\ShopAttributeGroup;
use Cart;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AuthorizenetController extends GeneralController
{
    public function processOrder() {
        $shippingAddress = session('shippingAddress') ?? [];
        $userName = $shippingAddress['first_name'] . " " . $shippingAddress['last_name'];
        $dataOrder = session('dataOrder') ?? [];
        $total = $dataOrder['total'];
        $orderID = session('orderID') ?? 0;
        if (!isset($userName) || !isset($total)) {
            return redirect()->route('home', ['error' => 'Cart is empty']);
        }
        return view($this->templatePath . '.shop_card_payment', array(
            'user_name' => $userName,
            'total_price' => $total,
            'orderID' => $orderID
        ));
    }

    public function processPayment() {
        $procRes = [
            'message' => '',
            'error_code' => 0
        ];
        $request = request()->all();
        $dataOrder = session('dataOrder') ?? [];
        if (!isset($dataOrder["total"]) || $dataOrder['total'] < 1) {
            $procRes['message'] = "Invalid session.";
            $procRes['error_code'] = 1;
            return response()->json($procRes);
        }
        /* Create a merchantAuthenticationType object with authentication details
          retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(sc_config('authorizenet_login_id'));
        $merchantAuthentication->setTransactionKey(sc_config('authorizenet_transaction_key'));

        // Set the transaction's refId
        $refId = 'ref' . time();
        $cardNumber = preg_replace('/\s+/', '', $request['cardNumber']);
        
        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate('20' . $request['expireYear'] . "-" .$request['expireMonth']);
        $creditCard->setCardCode($request['securityCode']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($dataOrder["total"]);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setCurrencyCode('USD');

        // LineItem
        $arrCartDetails = Cart::content();
        $lineItem_Array = [];
        $attributeGroups = ShopAttributeGroup::getList();
        
        foreach($arrCartDetails as $cartItem) {
            $attributes = ($cartItem->options) ? $cartItem->options : [];
            $attributeDetsils = [];
            foreach($attributes as $key => $option) {
                $attributeDetsils[$attributeGroups[$key]] = $option;
            }
            $description = implode(', ', array_map(
                function ($v, $k) { return sprintf("%s: %s", $k, $v); },
                $attributeDetsils,
                array_keys($attributeDetsils)
            ));
            $lineItem = new AnetAPI\LineItemType();
            $lineItem->setItemId($cartItem->id);
            $lineItem->setName(substr($cartItem->name, 0, 30));
            $lineItem->setDescription(substr($description, 0, 254));
            $lineItem->setQuantity($cartItem->qty);
            $lineItem->setUnitPrice($cartItem->price);
            $lineItem_Array[] = $lineItem;
        }
        $transactionRequestType->setLineItems($lineItem_Array);

        // Bill To Info
        $billto = new AnetAPI\CustomerAddressType();
        $billto->setFirstName($dataOrder['first_name']);
        $billto->setLastName($dataOrder['last_name']);
        $billto->setCompany($dataOrder['company']);
        $billto->setAddress($dataOrder['address1']);
        $billto->setZip($dataOrder['postcode']);
        $billto->setCountry($dataOrder['country']);
        $billto->setPhoneNumber($dataOrder['phone']);
        $billto->setEmail($dataOrder['email']);
        $transactionRequestType->setBillTo($billto);
        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $isSandbox = sc_config('authorizenet_is_sandbox');
        if ($isSandbox) {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                $tresponse = $response->getTransactionResponse();
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $orderID = session('orderID') ?? 0;
                    $dataInsert = [
                        'session_id' => $tresponse->getTransId(),
                        'content' => $tresponse->getAuthCode(),
                        'order_id' => $orderID,
                        'user_id' => auth()->user()->id
                    ];
                    
                    ShopCardTransaction::create($dataInsert);
                    (new ShopOrder)->updateStatus($orderID, $status = sc_config('card_order_status_success'), "Card Payment Success");
                    (new ShopCart)->completeOrder();
                    $procRes['message'] = $tresponse->getMessages()[0]->getDescription().", Transaction ID: " . $tresponse->getTransId();
                    $procRes['error_code'] = 0;
                } else {
                    $procRes['message'] = 'There were some issue with the payment. Please try again later.';
                    $procRes['error_code'] = 1;

                    if ($tresponse->getErrors() != null) {
                        $procRes['message'] = $tresponse->getErrors()[0]->getErrorText();
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $procRes['message'] = 'There were some issue with the payment. Please try again later.';
                $procRes['error_code'] = 1;

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $procRes['message'] = $tresponse->getErrors()[0]->getErrorText();
                } else {
                    $procRes['message'] = $response->getMessages()->getMessage()[0]->getText();
                }                
            }
        } else {
            $procRes['message'] = "No response returned";
            $procRes['error_code'] = 1;
        }

        return response()->json($procRes);
    }
}