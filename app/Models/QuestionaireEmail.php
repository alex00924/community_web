<?php
#app/Models/QuestionaireQuestion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionaireEmail extends Model
{
    public $timestamps = false;
    public $table      = 'questionaire_email';
    protected $fillable = ['id', 'questionaire_id', 'email'];

    protected $guarded = [];    

    protected static function boot()
    {
        parent::boot();
    }
}
