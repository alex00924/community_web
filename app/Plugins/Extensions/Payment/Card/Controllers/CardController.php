<?php
#App\Plugins\Extension\Payment\Card\Controllers\CardController.php
namespace App\Plugins\Extensions\Payment\Card\Controllers;


use App\Http\Controllers\ShopCart;
use App\Models\ShopOrder;
use App\Models\ShopCardTransaction;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Models\ShopAttributeGroup;
use Cart;

class CardController extends GeneralController
{
    public function processOrder() {
        try {
            $currency = sc_currency_code();
        
            $arrCartDetails = Cart::content();
            $lineItems = [];
            $attributeGroups = ShopAttributeGroup::getList();
            foreach($arrCartDetails as $cartItem) {
                $product = ShopProduct::find($cartItem->id);
                $arrDetail['name'] = $cartItem->name;
                $arrDetail['quantity'] = $cartItem->qty;
                $attributes = ($cartItem->options) ? $cartItem->options : [];
                $arrDetail['amount'] = sc_currency_value($cartItem->price) * 100;
                $arrDetail['images'] = [$product->image];
                $attributeDetsils = [];
                foreach($attributes as $key => $option) {
                    $attributeDetsils[$attributeGroups[$key]] = $option;
                }
                $description = implode(', ', array_map(
                    function ($v, $k) { return sprintf("%s: %s", $k, $v); },
                    $attributeDetsils,
                    array_keys($attributeDetsils)
                ));
                if (!empty($description)) {
                    $arrDetail['description'] = $description;
                }
                $arrDetail['currency'] = $currency;
                $lineItems[] = $arrDetail;
            }
            
            \Stripe\Stripe::setApiKey(sc_config('card_secret'));
            $session = \Stripe\Checkout\Session::create([
                'customer_email' => auth()->user()->email,
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'success_url' => route("card.complete") . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route("card.cancel"),
            ]);
            $html = '<body>
                        <div id="error-message">Redirecting....</div>
                    </body>
                    <script src="https://js.stripe.com/v3/"></script>
                    <script>
                        var stripe = Stripe("' . sc_config("card_public_key") . '");
                        stripe
                            .redirectToCheckout({
                                sessionId: "' . $session["id"] . '"
                            })
                            .then(function(result) {
                                if (result.error) {
                                  var displayError = document.getElementById("error-message");
                                  displayError.textContent = result.error.message;
                                }
                              });
                    </script>';
            return $html;
        }
        catch(Exception $e) {
            var_dump($e);
        }
    }

    public function complete(Request $request) {
        $orderID = session('orderID') ?? 0;
        if($orderID == 0){
            return $this->invalidRequest();
        }

        $session_id = $request->query("session_id");
        if (empty($session_id)) {
            return $this->invalidRequest();
        }
        $transaction = ShopCardTransaction::where('session_id', $session_id)->first();
        if ($transaction) {
            return $this->invalidRequest();
        }

        \Stripe\Stripe::setApiKey(sc_config('card_secret'));
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
            
            $dataInsert = [
                'session_id' => $session_id,
                'content' => json_encode($checkout_session),
                'order_id' => $orderID,
                'user_id' => auth()->user()->id
            ];
            
            ShopCardTransaction::create($dataInsert);

            //ShopOrder::updateInfo(["received" => $total], $orderID);
            (new ShopOrder)->updateStatus($orderID, $status = sc_config('card_order_status_success'), "Card Payment Success");
            return (new ShopCart)->completeOrder();
        }
        catch(Exception $ex) {
            echo json_encode($ex);
        }
    }

    public function invalidRequest() {
        $msg = "Invalid request was sent.";
        return redirect()->route('cart')->with(["error" => $msg]);
    }
    public function cancel() {
        $orderID = session('orderID') ?? 0;
        if($orderID == 0){
            return redirect()->route('home', ['error' => 'Error Order ID!']);
        }

        $msg = "You canceled card payment. Please try again";
        (new ShopOrder)->updateStatus($orderID, $status = sc_config('card_order_status_faild'), $msg);
        return redirect()->route('cart')->with(["error" => $msg]);
    }
}
