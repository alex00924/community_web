<?php
#app/Models/QuestionaireQuestionOption.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionaireQuestionOption extends Model
{
    public $timestamps = false;
    public $table      = 'questionaire_question_option';
    protected $guarded = [];
    
    public function question()
    {
        return $this->belongsTo(QuestionaireQuestion::class, 'question_id', 'id');
    }

    public function nextQuestion()
    {
        return $this->belongsTo(QuestionaireQuestion::class, 'next_question_id', 'id');
    }
}
