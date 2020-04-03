<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Questionaire;
use App\Models\QuestionaireQuestion;
use App\Models\QuestionaireAnswer;
use App\Models\QuestionaireQuestionOption;

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
        $user = Auth::user();
        $questionaire = null;

        $answers = $user->questionaireAnswers();
        $answeredIds = $user->questionaireAnswers()->groupBy('questionaire_id')->pluck('questionaire_id')->toArray();
        $questionaire = Questionaire::find($questionaire_id)->toArray();

        // if current user didn't answer for this questionaire, show questionaire edit page
        if (!in_array($questionaire_id, $answeredIds))
        {
            $questionaire['questions'] = QuestionaireQuestion::with(["options" => function($query) {
                    $query->orderBy('id');
                }])->where('questionaire_id', $questionaire["id"])->get();
            $data = [
                'questionaire' => $questionaire
            ];
            return view($this->templatePath . '.questionaire_survey')
                ->with($data);
        } 
        // if answered already, show answer details.
        else
        {
            if ($questionaire["type"] == "General")
            {
                $questionaire["questions"] = QuestionaireQuestion::where('questionaire_id', $questionaire["id"])->get()->toArray();
                foreach($questionaire["questions"] as $question_key => $question)
                {
                    $questionaire["questions"][$question_key]["options"] = QuestionaireQuestionOption::where('question_id', $question["id"])->select(["option"])->get()->toArray();
                    if ($question["answer_type"] == 'triangle')
                    {
                        $answers = QuestionaireAnswer::where('question_id', $question["id"])->select(["answer"])->get()->toArray();
                        $questionaire["questions"][$question_key]["answers"] = [];
                        foreach($answers as $answer_key => $answer)
                        {
                            $questionaire["questions"][$question_key]["answers"][] = json_decode($answer["answer"]);
                        }
                    }
                    else
                    {
                        foreach($questionaire["questions"][$question_key]["options"] as $option_key => $option)
                        {
                            $questionaire["questions"][$question_key]["options"][$option_key]["cnt"] = QuestionaireAnswer::where('question_id', $question["id"])->where('answer', $option["option"])->count();
                        }
                    }
                }
            }
            
            // Find current user's answer
            $answers = $user->questionaireAnswers()->where('questionaire_id', $questionaire_id)->get();
            foreach($answers as $key => $answer)
            {
                $answers[$key]['question'] = QuestionaireQuestion::with(["options" => function($query) {
                        $query->orderBy('id');
                    }])->find($answer->question_id);
            }
            $data = [
                'answers' => $answers,
                'questionaire' => $questionaire
            ];
            return view($this->templatePath . '.questionaire_detail')
                ->with($data);
        }
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