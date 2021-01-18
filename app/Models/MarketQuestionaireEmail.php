<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketQuestionaireUrl extends Model
{
    public $timestamps = false;
    public $table      = 'marketing_email';
    protected $guarded = [];
  
    protected static function boot()
    {
        parent::boot();
    }
}
