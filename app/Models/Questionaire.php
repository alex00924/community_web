<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questionaire extends Model
{
    public $timestamps = false;
    public $table      = 'questionaire';
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(QuestionaireQuestion::class, 'questionaire_id', 'id');
    }

    public function answers()
    {
        return $this->hasMany(QuestionaireAnswers::class, 'questionaire_id', 'id');
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
