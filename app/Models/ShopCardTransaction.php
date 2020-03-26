<?php
#app/Models/ShopProductReview.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCardTransaction extends Model
{
    public $timestamps = false;
    public $table      = 'shop_card_transaction';
    protected $guarded = [];
    
    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(ShopUser::class, 'user_id', 'id');
    }
}
