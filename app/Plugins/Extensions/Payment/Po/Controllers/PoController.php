<?php
#App\Plugins\Extension\Payment\Po\Controllers\PoController.php
namespace App\Plugins\Extensions\Payment\Po\Controllers;


use App\Http\Controllers\ShopCart;
use App\Models\ShopOrder;
use App\Models\ShopPoTransaction;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Models\ShopAttributeGroup;
use Cart;

class PoController extends GeneralController
{
    public function processOrder() {
        $orderID = session('orderID') ?? 0;
        (new ShopOrder)->updateStatus($orderID, $status = sc_config('po_order_status_success'), "New PO Requested");
        return (new ShopCart)->completeOrder();
    }
}
