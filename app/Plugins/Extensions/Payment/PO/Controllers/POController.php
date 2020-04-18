<?php
#App\Plugins\Extension\Payment\Po\Controllers\PoController.php
namespace App\Plugins\Extensions\Payment\PO\Controllers;


use App\Http\Controllers\ShopCart;
use App\Models\ShopOrder;
use App\Models\ShopPoTransaction;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Models\ShopAttributeGroup;
use Cart;

class POController extends GeneralController
{
    public function processOrder() {
        return (new ShopCart)->completeOrder();
    }
}
