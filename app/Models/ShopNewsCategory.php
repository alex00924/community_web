<?php
#app/Models/ShopNews.php
namespace App\Models;

use App\Models\ShopNews;
use Illuminate\Database\Eloquent\Model;

class ShopNewsCategory extends Model
{
    public $table = 'shop_news_category';
    protected $guarded = [];
   
    public function categorylist()
    {
        return $this->hasMany(ShopNews::class, 'category', 'category_name');
    }


}
