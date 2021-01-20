<?php
#app/Models/QuestionaireQuestionOption.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketQuestionaireQuestionOption extends Model
{
    public $timestamps = false;
    public $table      = 'marketing_question_option';
    protected $guarded = [];
    
    public function question()
    {
        return $this->belongsTo(MarketQuestionaireQuestion::class, 'question_id', 'id');
    }

    public function nextQuestion()
    {
        return $this->belongsTo(MarketQuestionaireQuestion::class, 'next_question_id', 'id');
    }
}
