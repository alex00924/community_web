<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    public $timestamps = false;
    public $table      = 'marketing';
    protected $guarded = [];
  
    protected static function boot()
    {
        parent::boot();
    }
}
