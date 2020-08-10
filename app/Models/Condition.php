<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $connection = 'mysql2';
    public $table         = 'conditions';

}
