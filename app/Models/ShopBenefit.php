<?php
#app/Models/ShopBenefit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopBenefit extends Model
{
    public $timestamps        = false;
    public $table             = 'shop_benefits';
    protected $guarded        = [];
    protected static $getList = null;

    public static function getList()
    {
        if (!self::$getList) {
            self::$getList = self::pluck('benefit', 'id')->all();
        }
        return self::$getList;
    }
    public function benefitDetails()
    {
        return $this->hasMany(ShopProductBenefit::class, 'benefit_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($benefit) {
            $benefit->benefitDetails()->delete();
        });
    }

}
