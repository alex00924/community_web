<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionaireQuestion extends Model
{
    public $timestamps = false;
    public $table      = 'questionaire_question';
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(QuestionaireQuestionOption::class, 'question_id', 'id');
    }
}
