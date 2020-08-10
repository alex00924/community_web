<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $connection = 'mysql2';
    public $table         = 'drugs';

}
