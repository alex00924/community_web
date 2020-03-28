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
        $questionaire = QuestionaireQuestion::get();
        $data = [
            'title' => trans('questionaire.admin.title'),
            'sub_title' => '',
            'icon' => 'fa fa-question',
            'languages' => $this->languages,
            'questionaire' => $questionaire
        ];
        return view('admin.screen.shop_questionaire')
            ->with($data);
    }

/**
 * Form create new order in admin
 * @return [type] [description]
 */
    public function create()
    {
        $htmlAnswer = '<tr id="answer_idx"><td><br><input type="text" name="answers[]" value="answer_value" class="form-control" placeholder="' . trans('questionaire.admin.add_answer_place') . '" required/></td><td class="fit-content"><br><span title="Remove" class="btn btn-flat btn-sm btn-danger removeAnswer"><i class="fa fa-times"></i></span></td></tr>';
        $data = [
            'title' => trans('questionaire.admin.add_new_title'),
            'title_description' => trans('questionaire.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'htmlAnswer' => $htmlAnswer
        ];

        return view('admin.screen.shop_questionaire_create')
            ->with($data);
    }

/**
 * Post create new order in admin
 * @return [type] [description]
 */
    public function postCreate()
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
            'answer_type' => $data['type']
        ];
        $question = QuestionaireQuestion::create($dataInsert);

        $answers = $data['answers'] ?? [];
        $answerOptions = [];
        foreach($answers as $answer) {
            $answerOptions[] = new QuestionaireQuestionOption(['option' => $answer]);
        }

        $question->options()->saveMany($answerOptions);

        return redirect()->route('admin_questionaire.index')->with('success', trans('questionaire.admin.create_success'));
    }

/**
 * Form edit
 */
    public function edit($id)
    {
        $question = QuestionaireQuestion::find($id);
        if ($question === null) {
            return 'no data';
        }

        $htmlAnswer = '<tr id="answer_idx"><td><br><input type="text" name="answers[]" value="answer_value" class="form-control" placeholder="' . trans('questionaire.admin.add_answer_place') . '" required/></td><td class="fit-content"><br><span title="Remove" class="btn btn-flat btn-sm btn-danger removeAnswer"><i class="fa fa-times"></i></span></td></tr>';
        $data = [
            'title' => trans('questionaire.admin.add_new_title'),
            'title_description' => trans('questionaire.admin.add_new_des'),
            'question' => $question,
            'htmlAnswer' => $htmlAnswer
        ];

        return view('admin.screen.shop_questionaire_edit')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
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
        $question->options()->delete();

        $answers = $data['answers'] ?? [];
        $answerOptions = [];
        foreach($answers as $answer) {
            $answerOptions[] = new QuestionaireQuestionOption(['option' => $answer]);
        }

        $question->options()->saveMany($answerOptions);

        return redirect()->route('admin_questionaire.index')->with('success', trans('questionaire.admin.edit_success'));
    }

/*
Delete list Item
Need mothod destroy to boot deleting in model
 */
    public function deleteList()
    {
        if (!request()->ajax()) {
            return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
        } else {
            $ids = request('ids');
            $arrID = explode(',', $ids);
            ShopNews::destroy($arrID);
            return response()->json(['error' => 0, 'msg' => '']);
        }
    }

}
