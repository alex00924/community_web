<?php
#app/Models/ShopAttributeGroup.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopAttributeGroup extends Model
{
    public $timestamps        = false;
    public $table             = 'shop_attribute_group';
    protected $guarded        = [];
    protected static $getList = null;
    protected static $getTypeList = null;

    public static function getList()
    {
        if (!self::$getList) {
            self::$getList = self::pluck('name', 'id')->all();
        }
        return self::$getList;
    }
    public static function getTypeList()
    {
        if (!self::$getTypeList) {
            self::$getTypeList = self::pluck('type', 'id')->all();
        }
        return self::$getTypeList;
    }
    public function attributeDetails()
    {
        return $this->hasMany(ShopProductAttribute::class, 'attribute_group_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($group) {
            $group->attributeDetails()->delete();
        });
    }

}
