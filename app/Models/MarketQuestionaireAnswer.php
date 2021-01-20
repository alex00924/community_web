<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketQuestionaireAnswer extends Model
{
    public $timestamps = true;
    public $table      = 'marketing_answer';
    protected $guarded = [];

    public function questionaire()
    {
        return $this->belongsTo(MarketQuestionaire::class, 'questionaire_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(MarketQuestionaireQuestion::class, 'question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(ShopUser::class, 'user_id', 'id');
    }
}
