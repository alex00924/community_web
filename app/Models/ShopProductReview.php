<?php
#app/Models/ShopProductReview.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductReview extends Model
{
    public $timestamps = true;
    public $table      = 'shop_product_review';
    protected $guarded = [];
    
    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(ShopUser::class, 'user_id', 'id');
    }
}
