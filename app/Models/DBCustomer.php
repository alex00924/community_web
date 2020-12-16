<?php
#app/Models/ShopCategory.php
namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;

class DBCustomer extends Model
{
    protected $fillable = ['fullname', 'firstname', 'lastname', 'current_company', 'interest', 'email', 'position', 'position_type', 'org_type', 'size', 'influencer_category', 'linkedin', 'notes', 'headline'];
    protected $guarded = [];
    public $timestamps = false;
    public $table = 'db_customer';   

}
