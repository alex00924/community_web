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
            'sub_title' => '',
            'title_description' => trans('questionaire.admin.add_new_des'),
            'icon' => 'fa fa-plus',
            'question' => [],
            'url_action' => route('admin_questionaire.create'),
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
        $shopNews = ShopNews::find($id);
        if ($shopNews === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('news.admin.edit'),
            'sub_title' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'languages' => $this->languages,
            'shopNews' => $shopNews,
            'url_action' => route('admin_news.edit', ['id' => $shopNews['id']]),
        ];
        return view('admin.screen.shop_news')
            ->with($data);
    }

/**
 * update status
 */
    public function postEdit($id)
    {
        $shopNews = ShopNews::find($id);
        $data = request()->all();

        $langFirst = array_key_first(sc_language_all()->toArray()); //get first code language active
        $data['alias'] = !empty($data['alias'])?$data['alias']:$data['descriptions'][$langFirst]['title'];
        $data['alias'] = sc_word_format_url($data['alias']);
        $data['alias'] = sc_word_limit($data['alias'], 100);

        $validator = Validator::make($data, [
            'descriptions.*.title' => 'required|string|max:200',
            'descriptions.*.keyword' => 'nullable|string|max:200',
            'descriptions.*.description' => 'nullable|string|max:300',
            'alias' => 'required|regex:/(^([0-9A-Za-z\-_]+)$)/|unique:shop_news,alias,' . $shopNews->id . ',id|string|max:100',
        ], [
            'alias.regex' => trans('news.alias_validate'),
            'descriptions.*.title.required' => trans('validation.required', ['attribute' => trans('news.title')]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($data);
        }
//Edit

        $dataUpdate = [
            'image' => $data['image'],
            'alias' => $data['alias'],
            'sort' => $data['sort'],
            'status' => !empty($data['status']) ? 1 : 0,
        ];

        $shopNews->update($dataUpdate);
        $shopNews->descriptions()->delete();
        $dataDes = [];
        foreach ($data['descriptions'] as $code => $row) {
            $dataDes[] = [
                'shop_news_id' => $id,
                'lang' => $code,
                'title' => $row['title'],
                'keyword' => $row['keyword'],
                'description' => $row['description'],
                'content' => $row['content'],
            ];
        }
        ShopNewsDescription::insert($dataDes);

//
        return redirect()->route('admin_news.index')->with('success', trans('news.admin.edit_success'));

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
