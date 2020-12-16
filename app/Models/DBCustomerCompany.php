<?php
#app/Models/ShopCategory.php
namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class DBCustomerCompany extends Model
{
    protected $fillable = ['company', 'treatment', 'indication', 'phase', 'characteristics', 'focus', 'portfolio', 'technology', 'website', 'additional_info', 'notes'];
    protected $guarded = [];
    public $timestamps = false;
    public $table = 'db_customer_company';   

}
