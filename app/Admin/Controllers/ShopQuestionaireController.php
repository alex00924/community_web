<?php
#app/Http/Admin/Controllers/ShopQuestionaireController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Models\QuestionaireQuestion;
use App\Models\QuestionaireQuestionOption;
use Illuminate\Http\Request;
use Validator;

class ShopQuestionaireController extends Controller
{
    public $languages;

    public function __construct()
    {
        $this->languages = ShopLanguage::getList();

    }

    public function index()
    {
        
    }

    public function indexQuestions($questionaire_id)
    {
        $questionaire = Questionaire::find($questionaire_id)->questions()->with('options')->get();
        $data = [
            'title' => trans('questionaire.admin.title'),
            'sub_title' => '',
            'icon' => 'fa fa-question',
            'languages' => $this->languages,
            'questionaire' => $questionaire,
            'questionaire_id' => $questionaire_id
        ];
        return view('admin.screen.shop_questionaire_question')
            ->with($data);
    }
/**
 * Form create new order in admin
 * @return [type] [description]
 */
    public function createQuestion($questionaire_id)
    {
        $htmlAnswer = '<tr id="answer_idx"><td><br><input type="text" name="answers[]" value="answer_value" class="form-control" placeholder="' . trans('questionaire.admin.add_answer_place') . '" required/></td><td class="fit-content"><br><span title="Remove" class="btn btn-flat btn-sm btn-danger removeAnswer"><i class="fa fa-times"></i></span></td></tr>';
        $data = [
            'title' => trans('questionaire.admin.add_new_title'),
            'title_description' => trans('questionaire.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'htmlAnswer' => $htmlAnswer,
            'questionaire_id' => $questionaire_id
        ];

        return view('admin.screen.shop_questionaire_create_question')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreateQuestion($questionaire_id)
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'question' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $dataInsert = [
            'question' => $data['question'],
            'answer_type' => $data['type'],
            'questionaire_id' => $questionaire_id
        ];
        $question = QuestionaireQuestion::create($dataInsert);

        $answers = $data['answers'] ?? [];
        $answerOptions = [];
        foreach($answers as $answer) {
            $answerOptions[] = new QuestionaireQuestionOption(['option' => $answer]);
        }

        $question->options()->saveMany($answerOptions);

        return redirect()->route('admin_questionaire.indexQuestion', ['questionaire_id' => $questionaire_id])->with('success', trans('questionaire.admin.create_success'));
    }

/**
 * Form edit
 */
    public function editQuestion($questionaire_id, $id)
    {
        $question = QuestionaireQuestion::with(['options' => function($query) {
            $query->orderBy('id');
        }])->find($id);
        
        if ($question === null) {
            return 'no data';
        }

        $htmlAnswer = '<tr id="answer_idx"><td><br><input type="hidden" name="answer_ids[]" value="answer_id_value"> <input type="text" name="answers[]" value="answer_value" class="form-control" placeholder="' . trans('questionaire.admin.add_answer_place') . '" required/></td><td class="fit-content"><br><span title="Remove" class="btn btn-flat btn-sm btn-danger removeAnswer"><i class="fa fa-times"></i></span></td></tr>';
        $data = [
            'title' => trans('questionaire.admin.edit_title'),
            'title_description' => trans('questionaire.admin.edit_des'),
            'question' => $question,
            'htmlAnswer' => $htmlAnswer,
            'questionaire_id' => $questionaire_id
        ];

        return view('admin.screen.shop_questionaire_edit_question')
            ->with($data);
    }

/**
 * update status
 */
    public function postEditQuestion($questionaire_id, $id)
    {
        $data = request()->all();
        
        $validator = Validator::make($data, [
            'question' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        $question = QuestionaireQuestion::find($id);

        $dataUpdate = [
            'question' => $data['question'],
            'answer_type' => $data['type']
        ];
        $question->update($dataUpdate);



        $answers = $data['answers'] ?? [];
        $answerIds = $data['answer_ids'] ?? [];

        $newAnswerOptions = [];
        $options = $question->options()->get();

        // delete invalid options
        foreach($options as $option) {
            if (!in_array($option->id, $answerIds)) {
                $option->delete();
            }
        }

        foreach($answers as $key=>$answer) {
            if ($answerIds[$key] == -1) {
                $newAnswerOptions[] = new QuestionaireQuestionOption(['option' => $answer]);
            } else {
                $options->find($answerIds[$key])->update(['option' => $answer]);
            }
        }
        $question->options()->saveMany($newAnswerOptions);

        return redirect()->route('admin_questionaire.indexQuestion', ['questionaire_id' => $questionaire_id])->with('success', trans('questionaire.admin.edit_success'));
    }

/*
Delete list Item
Need mothod destroy to boot deleting in model
 */
    public function deleteQuestion($id)
    {
        if ($id < 1) {
            return response()->json(['error' => 1, 'msg' => 'Invalid Request']);
        }
        QuestionaireQuestion::destroy($id);
        QuestionaireQuestionOption::where('next_question_id', '=', $id)->update(['next_question_id' => null]);
        return response()->json(['error' => 0, 'msg' => '']);
    }

    // update questionaire next question id
    public function updateNextQuestion()
    {
        $data = request()->all();
        $question = QuestionaireQuestion::find($data["question"]);
        if (empty($question)) {
            return "Invalid question id";
        }

        $nextQuestion = QuestionaireQuestion::find($data["nextQuestion"]);
        if (empty($nextQuestion)) {
            return "Invalid next question id";
        }

        $option = $question->options()->find($data['option']);
        if (empty($option)) {
            return "Invalid option id";
        }

        $option->update(['next_question_id' => $nextQuestion->id]);
        return "update next question success";
    }
}
