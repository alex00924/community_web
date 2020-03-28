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

    public function answers()
    {
        return $this->hasMany(QuestionaireAnswer::class, 'question_id', 'id');
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
