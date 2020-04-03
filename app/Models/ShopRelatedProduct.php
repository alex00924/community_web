<?php
#app/Models/ShopRelatedProduct.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopRelatedProduct extends Model
{
    public $timestamps = false;
    public $table      = 'shop_product_relationship';
    protected $guarded = [];
    
    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }

    public function relatedProduct()
    {
        return $this->belongsTo(ShopProduct::class, 'related_product_id', 'id');
    }
}
