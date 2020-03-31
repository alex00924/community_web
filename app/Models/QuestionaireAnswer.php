<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionaireAnswer extends Model
{
    public $timestamps = true;
    public $table      = 'questionaire_answer';
    protected $guarded = [];

    public function questionaire()
    {
        return $this->belongsTo(Questionaire::class, 'questionaire_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(QuestionaireQuestion::class, 'question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(ShopUser::class, 'user_id', 'id');
    }
}
