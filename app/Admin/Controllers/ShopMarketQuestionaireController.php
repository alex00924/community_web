<?php
#app/Http/Admin/Controllers/ShopQuestionaireController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopLanguage;
use App\Models\MarketQuestionaireQuestion;
use App\Models\MarketQuestionaire;
use App\Models\ShopProduct;
use App\Models\MarketQuestionaireQuestionOption;
use App\Models\MarketQuestionaireAnswer;
use App\Models\MarketQuestionaireUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class ShopMarketQuestionaireController extends Controller
{
    public $languages;

    public function __construct()
    {
        $this->languages = ShopLanguage::getList();

    }
/////////////---------------Questionire --------------/////////////
    public function index()
    {
        $questionaire = MarketQuestionaire::get();
        $data = [
            'category' => 'marketing',
            'title' => trans('questionaire.marketing.title'),
            'sub_title' => '',
            'icon' => 'fa fa-question',
            'languages' => $this->languages,
            'questionaires' => $questionaire
        ];
        return view('admin.screen.shop_questionaire')
            ->with($data);
    }
    /**
     * Form create new questionaire in admin
     */
    public function create()
    {
        $products = ShopProduct::get();
        $data = [
            'category' => 'marketing',
            'title' => trans('questionaire.marketing.add_new_questionaire_title'),
            'title_description' => trans('questionaire.marketing.add_new_questionaire_des'),
            'icon' => 'fa fa-plus',
            'products' => $products,
        ];

        return view('admin.screen.shop_questionaire_create')
            ->with($data);
    }

    /**
    * Post create new question in admin
    */
    public function postCreate()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }

        $dataInsert = [
            'title' => $data['title'],
            'type' => $data['type'],
            'target_id' => $data["target_id"],
            'access_level' => $data["access_level"]
        ];
        $question = MarketQuestionaire::create($dataInsert);
        return redirect()->route('admin_marketquestionaire.index')->with('success', trans('questionaire.marketing.create_questionaire_success'));
    }

    /**
    * Form edit
    */
    public function edit($id)
    {
        $products = ShopProduct::get();
        $questionaire = MarketQuestionaire::find($id);
        
        if ($questionaire === null || $products == null) {
            return 'no data';
        }

        $data = [
            'category' => 'marketing',
            'title' => trans('questionaire.marketing.edit_questionaire_title'),
            'title_description' => trans('questionaire.marketing.edit_questionaire_des'),
            'questionaire' => $questionaire,
            'products' => $products,
        ];

        return view('admin.screen.shop_questionaire_edit')
            ->with($data);
    }

    /**
    * Update question
    */
    public function postEdit($id)
    {
        $data = request()->all();
        
        $validator = Validator::make($data, [
            'title' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
        $questionaire = MarketQuestionaire::find($id);

        $dataUpdate = [
            'title' => $data['title'],
            'type' => $data['type'],
            'target_id' => $data['target_id'],
            'access_level' => $data['access_level']
        ];
        $questionaire->update($dataUpdate);

        return redirect()->route('admin_marketquestionaire.index')->with('success', trans('questionaire.admin.edit_success'));
    }

    /*
    Delete list Item
    Need mothod destroy to boot deleting in model
    */
    public function delete($id)
    {
        if ($id < 1) {
            echo json_encode(array('error' => 1, 'msg' => 'Invalid Request'));
        }
        MarketQuestionaire::destroy($id);
        echo json_encode(array('error' => 0, 'msg' => ''));
    }


/////////////---------------Question--------------/////////////
    public function indexQuestions($questionaire_id)
    {
        $questionaire = MarketQuestionaire::find($questionaire_id);
        $questionaireQuestions = $questionaire->questions()->with('options')->get();
        $data = [
            'category' => 'marketing',
            'title' => trans('questionaire.admin.title'),
            'sub_title' => $questionaire->title,
            'icon' => 'fa fa-question',
            'languages' => $this->languages,
            'questionaire' => $questionaireQuestions,
            'questionaire_id' => $questionaire_id
        ];
        return view('admin.screen.shop_questionaire_question')
            ->with($data);
    }
    /**
     * Form create new question in admin
     */
    public function createQuestion($questionaire_id)
    {
        $htmlAnswer = '<tr id="answer_idx"><td><br><input type="text" name="answers[]" value="answer_value" class="form-control" placeholder="' . trans('questionaire.admin.add_answer_place') . '" required/></td><td class="fit-content"><br><span title="Remove" class="btn btn-flat btn-sm btn-danger removeAnswer"><i class="fa fa-times"></i></span></td></tr>';
        $data = [
            'category' => 'marketing',
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
     * Post create new question in admin
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
        $question = MarketQuestionaireQuestion::create($dataInsert);

        $answers = $data['answers'] ?? [];
        $answerOptions = [];
        foreach($answers as $answer) {
            $answerOptions[] = new MarketQuestionaireQuestionOption(['option' => $answer]);
        }

        $question->options()->saveMany($answerOptions);

        return redirect()->route('admin_marketquestionaire.indexQuestion', ['questionaire_id' => $questionaire_id])->with('success', trans('questionaire.admin.create_success'));
    }

    /**
     * Form edit
     */
    public function editQuestion($questionaire_id, $id)
    {
        $question = MarketQuestionaireQuestion::with(['options' => function($query) {
            $query->orderBy('id');
        }])->find($id);
        
        if ($question === null) {
            return 'no data';
        }

        $htmlAnswer = '<tr id="answer_idx"><td><br><input type="hidden" name="answer_ids[]" value="answer_id_value"> <input type="text" name="answers[]" value="answer_value" class="form-control" placeholder="' . trans('questionaire.admin.add_answer_place') . '" required/></td><td class="fit-content"><br><span title="Remove" class="btn btn-flat btn-sm btn-danger removeAnswer"><i class="fa fa-times"></i></span></td></tr>';
        $data = [
            'category' => 'marketing',
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
     * Update question
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
        $question = MarketQuestionaireQuestion::find($id);

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
                $newAnswerOptions[] = new MarketQuestionaireQuestionOption(['option' => $answer]);
            } else {
                $options->find($answerIds[$key])->update(['option' => $answer]);
            }
        }
        $question->options()->saveMany($newAnswerOptions);

        return redirect()->route('admin_marketquestionaire.indexQuestion', ['questionaire_id' => $questionaire_id])->with('success', trans('questionaire.admin.edit_success'));
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
        MarketQuestionaireQuestion::destroy($id);
        MarketQuestionaireQuestionOption::where('next_question_id', '=', $id)->update(['next_question_id' => null]);
        return response()->json(['error' => 0, 'msg' => '']);
    }

    // update questionaire next question id
    public function updateNextQuestion()
    {
        $data = request()->all();
        $question = MarketQuestionaireQuestion::find($data["question"]);
        if (empty($question)) {
            return "Invalid question id";
        }

        $nextQuestion = MarketQuestionaireQuestion::find($data["nextQuestion"]);
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

    /**
     * Generate URL
     */
    public function generateUrl()
    {
        $data = [
            'category' => 'marketing',
            'title' => trans('questionaire.marketing.generate_url_title'),
            'title_description' => trans('questionaire.marketing.generate_url_des'),
            'icon' => 'fa fa-plus',
        ];
        return view('admin.screen.shop_questionaire_generateurl')
            ->with($data);
    }
    public function updateUrl(Request $request)
    {
      $id = $request -> id;
      $questionaireurl = MarketQuestionaireUrl::get()->first();
      $dataUpdate = [
          'url' => $id,
      ];
      $questionaireurl->update($dataUpdate);
      echo json_encode(array('error' => 0, 'msg' => '')); exit;
    }
}
