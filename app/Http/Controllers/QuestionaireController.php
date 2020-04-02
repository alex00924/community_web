<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Questionaire;
use App\Models\QuestionaireQuestion;
use App\Models\QuestionaireAnswer;

class QuestionaireController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $questionaires = Questionaire::get();
        $data = [
            'questionaires' => $questionaires
        ];
        return view($this->templatePath . '.questionaire')
            ->with($data);
    }

    public function detail($questionaire_id)
    {
        $data = [];
        return view($this->templatePath . '.questionaire_detail')
        ->with($data);
    }

    public function addAnswer()
    {
        $data = request()->all();
        $questionaireId = $data["questionaire_id"];
        $answers = $data["answers"];
        $userId = auth()->user()->id;

        foreach($answers as $answer)
        {
            $dataInsert = [
                "user_id" => $userId,
                "questionaire_id" => $questionaireId,
                "question_id" => $answer["question_id"],
                "answer" => $answer["answer"]
            ];
            QuestionaireAnswer::create($dataInsert);
        }
        return 'ok';
    }
}

?>