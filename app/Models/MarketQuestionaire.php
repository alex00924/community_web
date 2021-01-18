<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketQuestionaire extends Model
{
    public $timestamps = false;
    public $table      = 'marketing';
    protected $guarded = [];
    
    public function questions()
    {
        return $this->hasMany(MarketQuestionaireQuestion::class, 'questionaire_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(MarketQuestionaireAnswers::class, 'questionaire_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($questionaire) {
            $questionaire->questions()->delete();
        });
    }
}
