<?php
#app/Models/ShopProductBenefit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductBenefit extends Model
{
    public $timestamps = false;
    public $table      = 'shop_product_benefits';
    protected $guarded = [];
    public function benefit()
    {
        return $this->belongsTo(ShopBenefit::class, 'benefit_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }
}
