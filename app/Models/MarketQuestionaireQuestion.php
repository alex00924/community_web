<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketQuestionaireQuestion extends Model
{
    public $timestamps = false;
    public $table      = 'marketing_question';
    protected $guarded = [];
    
    public function options()
    {
        return $this->hasMany(MarketQuestionaireQuestionOption::class, 'question_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(MarketQuestionaireAnswer::class, 'question_id', 'id');
    }

    public function questionaire()
    {
        return $this->belongsTo(MarketQuestionaire::class, 'questionaire_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($question) {
            $question->options()->delete();
            $question->answers()->delete();
        });
    }
}
