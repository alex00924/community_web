<?php
#app/Http/Admin/Controllers/ShopCategoryController.php
namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DBCustomer;
use App\Models\DBCustomerCompany;
use Illuminate\Http\Request;
use App\Models\ShopLanguage;
use Illuminate\Support\Facades\Session;
use Validator;
use Exception;

class DBCustomerController extends Controller
{   
    public $languages;

    public function __construct()
    {
        $this->languages = ShopLanguage::getList();

    }

    public function index()
    {
        $data = [
            'title' => trans('db_customer.admin.individual'),
            'sub_title' => '',
            'icon' => 'fa fa-indent',
            'menu_left' => '',
            'menu_right' => '',
            'menu_sort' => '',
            'script_sort' => '',
            'menu_search' => '',
            'script_search' => '',
            'listTh' => '',
            'dataTr' => '',
            'pagination' => '',
            'result_items' => '',
            'url_delete_item' => '',
        ];

        $listTh = [
            'check_row' => '',
            'id' => trans('db_customer.admin.id'),
            'fullname' => trans('db_customer.admin.fullname'),
            'firstname' => trans('db_customer.admin.firstname'),
            'lastname' => trans('db_customer.admin.lastname'),
            'current_company' => trans('db_customer.admin.current_company'),
            'interest' => trans('db_customer.admin.interest'),
            'email' => trans('db_customer.admin.email'),
            'position' => trans('db_customer.admin.position'),
            'position_type' => trans('db_customer.admin.position_type'),
            'org_type' => trans('db_customer.admin.org_type'),
            'size' => trans('db_customer.admin.size'),
            'influencer_category' => trans('db_customer.admin.influencer_category'),
            'linkedin' => trans('db_customer.admin.linkedin'),
            'notes' => trans('db_customer.admin.notes'),
            'headline' => trans('db_customer.admin.headline'),
            'action' => trans('db_customer.admin.action')
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('db_customer.admin.sort_order.id_desc'),
            'id__asc' => trans('db_customer.admin.sort_order.id_asc'),
            'fullname__desc' => trans('db_customer.admin.sort_order.name_desc'),
            'fullname__asc' => trans('db_customer.admin.sort_order.name_asc'),
        ];
        $obj = new DBCustomer;
      
       
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $obj = $obj->orderBy($field, $sort_field);

        } else {
            $obj = $obj->orderBy('id', 'desc');
        }
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'check_row' => '<input type="checkbox" class="grid-row-checkbox" data-id="' . $row['id'] . '">',
                'id' => $row['id'],
                'fullname' => $row['fullname'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'current_company' => $row['current_company'],
                'interest' => $row['interest'],
                'email' => $row['email'],
                'position' => $row['position'],
                'position_type' => $row['position_type'],
                'org_type' => $row['org_type'],
                'size' => $row['size'],
                'influencer_category' => $row['influencer_category'],
                'linkedin' => $row['linkedin'],
                'notes' => $row['notes'],
                'headline' => $row['headline'],
                'action' => Session::get('userrole') == 1?'
                    <div style="display: flex;">
                    <a href="' . route('admin_dbcumstomer.individual.edit', ['id' => $row['id']]) . '"><span title="' . trans('db_customer.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                    </div>'
                    :
                    '<a href="' . route('admin_dbcumstomer.individual.edit', ['id' => $row['id']]) . '"><span title="' . trans('category.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['result_items'] = trans('category.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);
        //menu_left
        $data['menu_left'] = Session::get('userrole') == 1?'<div class="pull-left">
                      <button type="button" class="btn btn-default grid-select-all"><i class="fa fa-square-o"></i></button> &nbsp;
                      <a class="btn   btn-flat btn-danger grid-trash" title="Delete"><i class="fa fa-trash-o"></i><span class="hidden-xs"> ' . trans('admin.delete') . '</span></a> &nbsp;
                      <form id="insert_individual" role="form" method="post" action="' . route('admin_dbcumstomer.individual.import') . '" enctype=' . 'multipart/form-data' . ' style="display: inline;">
                          <input name="_token" value="{{ csrf_token() }}" type="hidden">
                          <input type="file" name="import_individual" id="import_individual" style="display: none;" accept=".csv"/>
                          <label class="uploadButton" for="import_individual"><i class="fa fa-sign-in"></i><span>'. trans('db_customer.admin.import') . ' (.csv)' .'</span></label>
                          <button type="button" class="button_simple" id="savein_db"><p><strong>'. trans('db_customer.admin.save_db') . '</strong></p></button>
                      </form>
                    </div>
                    '
                    :
                    '<div class="pull-left">
                    <button type="button" class="btn btn-default grid-select-all"><i class="fa fa-square-o"></i></button> &nbsp;
                    <a class="btn   btn-flat btn-success" title="Import"><i class="fa fa-sign-in"></i><span class="hidden-xs"> ' . trans('db_customer.admin.import') . ' (.csv)' . '</span></a> &nbsp;</div>
                    ';
        //=menu_left

        //menu_right
        $data['menu_right'] = '
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="' . env('APP_URL'). '/uploads/individual.csv" target="_blank" id="download-individual-csv" style="margin-right: 1rem; float: left; margin-top: 7px">Download</a>
                            <a href="' . route('admin_dbcumstomer.individual.export') . '" class="btn  btn-info  btn-flat" title="New" id="button_create_new" style="margin-right: 10px;">
                            <i class="fa fa-sign-out"></i><span class="hidden-xs">' . trans('db_customer.admin.export') . ' (.csv)' . '</span>
                            </a>
                            <a href="' . route('admin_dbcumstomer.individual.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                            <i class="fa fa-plus"></i><span class="hidden-xs">' . trans('admin.add_new') . '</span>
                            </a>
                        </div>
                        ';
        //=menu_right

        //menu_sort

        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['menu_sort'] = '
                       <div class="btn-group pull-left">
                        <div class="form-group">
                           <select class="form-control" id="order_sort">
                            ' . $optionSort . '
                           </select>
                         </div>
                       </div>

                       <div class="btn-group pull-left">
                           <a class="btn btn-flat btn-primary" title="Sort" id="button_sort">
                              <i class="fa fa-sort-amount-asc"></i><span class="hidden-xs"> ' . trans('admin.sort') . '</span>
                           </a>
                       </div>';

        $data['script_sort'] = "$('#button_sort').click(function(event) {
      var url = '" . route('admin_dbcumstomer.individual.index') . "?sort_order='+$('#order_sort option:selected').val();
      $.pjax({url: url, container: '#pjax-container'})
    });";

    //=menu_sort

    //menu_search

        $data['menu_search'] = '
                <form action="' . route('admin_category.index') . '" id="button_search">
                   <div onclick="$(this).submit();" class="btn-group pull-right">
                           <a class="btn btn-flat btn-primary" title="Refresh">
                              <i class="fa  fa-search"></i><span class="hidden-xs"> ' . trans('admin.search') . '</span>
                           </a>
                   </div>
                   <div class="btn-group pull-right">
                         <div class="form-group">
                           <input type="text" name="keyword" class="form-control" placeholder="' . trans('db_customer.admin.search_place') . '" value="' . $keyword . '">
                         </div>
                   </div>
                </form>';
    //=menu_search

        $data['url_delete_item'] = route('admin_dbcumstomer.individual.delete');

        return view('admin.screen.list')
            ->with($data);
    }

    /**
     * Form create new order in admin
     * @return [type] [description]
     */
    public function createIndividual()
    {
        $data = [
            'title' => trans('db_customer.admin.add_new_individual'),
            'sub_title' => '',
            'title_description' => trans('db_customer.admin.add_new_individual_des'),
            'icon' => 'fa fa-plus',
            'languages' => $this->languages,
            'individual' => [],
            'url_action' => route('admin_dbcumstomer.individual.create'),
        ];
        return view('admin.screen.db_customer')
            ->with($data);
    }

    /**
    * Post create new order in admin
    * @return [type] [description]
    */
    public function postCreateIndividual()
    {
        $data = request()->all();

        $dataInsert = [
            'fullname' => $data['fullname'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'current_company' => $data['current_company'],
            'interest' => $data['interest'],
            'email' => $data['email'],
            'position' => $data['position'],
            'position_type' => $data['position_type'],
            'org_type' => $data['org_type'],
            'size' => $data['size'],
            'influencer_category' => $data['influencer_category'],
            'linkedin' => $data['linkedin'],
            'notes' => $data['notes'],
            'headline' => $data['headline'],
        ];
        DBCustomer::create($dataInsert);

        return redirect()->route('admin_dbcumstomer.individual.index')->with('success', trans('db_customer.admin.create_success'));

    }
    /**
   * Form edit
   */
    public function editIndividual($id)
    {
        $individual = DBCustomer::find($id);
        if ($individual === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('admin.edit'),
            'sub_title' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'languages' => $this->languages,
            'individual' => $individual,
            'url_action' => route('admin_dbcumstomer.individual.edit', ['id' => $individual['id']]),
        ];
        return view('admin.screen.db_customer')
            ->with($data);
    }

    /**
     * update status
    */
    public function editPostIndividual($id)
    {
      $individual = DBCustomer::find($id);
      $data = request()->all();
      $dataUpdate = [
          'fullname' => $data['fullname'],
          'firstname' => $data['firstname'],
          'lastname' => $data['lastname'],
          'current_company' => $data['current_company'],
          'interest' => $data['interest'],
          'email' => $data['email'],
          'postion' => $data['position'],
          'position_type' => $data['position_type'],
          'org_type' => $data['org_type'],
          'size' => $data['size'],
          'influencer_category' => $data['influencer_category'],
          'linkedin' => $data['linkedin'],
          'notes' => $data['notes'],
          'headline' => $data['headline'],
      ];
      $individual->update($dataUpdate);
      return redirect()->route('admin_dbcumstomer.individual.index')->with('success', trans('admin_dbcumstomer.edit_success'));
    }

    public function deleteIndividual()
    {
      if (!request()->ajax()) {
        return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
      } else {
          $ids = request('ids');
          $arrID = explode(',', $ids);
          DBCustomer::destroy($arrID);
          return response()->json(['error' => 0, 'msg' => '']);
      }
    }

    public function importIndividual()
    {
      $path = request()->import_individual;
      $inputfile = fopen($path,"r");
      $output = [];
      fgetcsv($inputfile, 1000, ",");
      while (($data = fgetcsv($inputfile, 1000, ",")) !== FALSE) {
          $output[] = $data;
      }
      foreach ($output as $line) {
          $dataUpdate = [
            'fullname' => $line[0],
            'firstname' => $line[1],
            'lastname' => $line[2],
            'current_company' => $line[3],
            'interest' => $line[4],
            'email' => $line[5],
            'position' => $line[6],
            'position_type' => $line[7],
            'org_type' => $line[8],
            'size' => $line[9],
            'influencer_category' => $line[10],
            'linkedin' => $line[11],
            'notes' => $line[12],
            'headline' => $line[13],
          ];
          DBCustomer::create($dataUpdate);
      }
      echo json_encode(array('res' => 1));
      fclose($inputfile);
    }
   
    public function exportIndividual()
    {
      $fields = DBCustomer::get();
      $outputfile = fopen("./uploads/individual.csv","w");
        $columns = array('Company', 'Full Name', 'First Name', 'Last Name', 'Current Company', 'interest', 'Email', 'Position Type', 'Org Type', 'Size', 'Influencer category', 'Linked In', 'Notes', 'Headline');
        fputcsv($outputfile, $columns);
        foreach ($fields as $line) {
            fputcsv($outputfile, array($line->fullname, $line->firstname, $line->lastname, $line->current_company, $line->interest, $line->email, $line->position_type, $line->org_type, $line->size, $line->influencer_category, $line->linkedin, $line->notes, $line->influencer_category));
        }
        fclose($outputfile);
      return redirect()->route('admin_dbcumstomer.individual.index')->with('success', trans('admin_dbcumstomer.export_success'));
    }


    public function companyindex()
    {
        $data = [
            'title' => trans('db_customer.admin.company'),
            'sub_title' => '',
            'icon' => 'fa fa-indent',
            'menu_left' => '',
            'menu_right' => '',
            'menu_sort' => '',
            'script_sort' => '',
            'menu_search' => '',
            'script_search' => '',
            'listTh' => '',
            'dataTr' => '',
            'pagination' => '',
            'result_items' => '',
            'url_delete_item' => '',
        ];

        $listTh = [
            'check_row' => '',
            'id' => trans('db_customer.admin.id'),
            'company' => trans('db_customer.admin.company'),
            'treatment' => trans('db_customer.admin.treatment'),
            'indication' => trans('db_customer.admin.indication'),
            'phase' => trans('db_customer.admin.phase'),
            'characteristics' => trans('db_customer.admin.characteristics'),
            'focus' => trans('db_customer.admin.focus'),
            'portfolio' => trans('db_customer.admin.portfolio'),
            'technology' => trans('db_customer.admin.technology'),
            'website' => trans('db_customer.admin.website'),
            'additional_info' => trans('db_customer.admin.additional_info'),
            'notes' => trans('db_customer.admin.notes'),
            'action' => trans('db_customer.admin.action')
        ];
        $sort_order = request('sort_order') ?? 'id_desc';
        $keyword = request('keyword') ?? '';
        $arrSort = [
            'id__desc' => trans('db_customer.admin.sort_order.id_desc'),
            'id__asc' => trans('db_customer.admin.sort_order.id_asc'),
            'company__desc' => trans('db_customer.admin.sort_order.name_desc'),
            'company__asc' => trans('db_customer.admin.sort_order.name_asc'),
        ];
        $obj = new DBCustomerCompany;
      
       
        if ($sort_order && array_key_exists($sort_order, $arrSort)) {
            $field = explode('__', $sort_order)[0];
            $sort_field = explode('__', $sort_order)[1];
            $obj = $obj->orderBy($field, $sort_field);

        } else {
            $obj = $obj->orderBy('id', 'desc');
        }
        $dataTmp = $obj->paginate(20);

        $dataTr = [];
        foreach ($dataTmp as $key => $row) {
            $dataTr[] = [
                'check_row' => '<input type="checkbox" class="grid-row-checkbox" data-id="' . $row['id'] . '">',
                'id' => $row['id'],
                'company' => $row['company'],
                'treatment' => $row['treatment'],
                'indication' => $row['indication'],
                'phase' => $row['phase'],
                'characteristics' => $row['characteristics'],
                'focus' => $row['focus'],
                'portfolio' => $row['portfolio'],
                'technology' => $row['technology'],
                'website' => $row['website'],
                'additional_info' => $row['additional_info'],
                'notes' => $row['notes'],
                'action' => Session::get('userrole') == 1?'
                    <div style="display: flex;">
                    <a href="' . route('admin_dbcumstomer.company.edit', ['id' => $row['id']]) . '"><span title="' . trans('db_customer.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;

                    <span onclick="deleteItem(' . $row['id'] . ');"  title="' . trans('admin.delete') . '" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>
                    </div>'
                    :
                    '<a href="' . route('admin_dbcumstomer.company.edit', ['id' => $row['id']]) . '"><span title="' . trans('category.admin.edit') . '" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>&nbsp;'
                ,
            ];
        }

        $data['listTh'] = $listTh;
        $data['dataTr'] = $dataTr;
        $data['pagination'] = $dataTmp->appends(request()->except(['_token', '_pjax']))->links('admin.component.pagination');
        $data['result_items'] = trans('category.admin.result_item', ['item_from' => $dataTmp->firstItem(), 'item_to' => $dataTmp->lastItem(), 'item_total' => $dataTmp->total()]);
        //menu_left
        $data['menu_left'] = Session::get('userrole') == 1?'<div class="pull-left">
                      <button type="button" class="btn btn-default grid-select-all"><i class="fa fa-square-o"></i></button> &nbsp;
                      <a class="btn   btn-flat btn-danger grid-trash" title="Delete"><i class="fa fa-trash-o"></i><span class="hidden-xs"> ' . trans('admin.delete') . '</span></a> &nbsp;
                      <form id="insert_company" role="form" method="post" action="' . route('admin_dbcumstomer.company.import') . '" enctype=' . 'multipart/form-data' . ' style="display: inline;">
                          <input name="_token" value="{{ csrf_token() }}" type="hidden">
                          <input type="file" name="import_company" id="import_company" style="display: none;" accept=".csv"/>
                          <label class="uploadButton" for="import_company"><i class="fa fa-sign-in"></i><span>'. trans('db_customer.admin.import') . ' (.csv)' .'</span></label>
                          <button type="button" class="button_simple" id="savein_db_company"><p><strong>'. trans('db_customer.admin.save_db') . '</strong></p></button>
                      </form>
                    </div>
                    '
                    :
                    '<div class="pull-left">
                    <button type="button" class="btn btn-default grid-select-all"><i class="fa fa-square-o"></i></button> &nbsp;
                    <a class="btn   btn-flat btn-success" title="Import"><i class="fa fa-sign-in"></i><span class="hidden-xs"> ' . trans('db_customer.admin.import') . ' (.csv)' . '</span></a> &nbsp;</div>
                    ';
        //=menu_left

        //menu_right
        $data['menu_right'] = '
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="' . env('APP_URL'). '/uploads/company.csv" target="_blank" id="download-individual-csv" style="margin-right: 1rem; float: left; margin-top: 7px">Download</a>
                            <a href="' . route('admin_dbcumstomer.company.export') . '" class="btn  btn-info  btn-flat" title="New" id="button_create_new" style="margin-right: 10px;">
                            <i class="fa fa-sign-out"></i><span class="hidden-xs">' . trans('db_customer.admin.export') . ' (.csv)' . '</span>
                            </a>
                            <a href="' . route('admin_dbcumstomer.company.create') . '" class="btn  btn-success  btn-flat" title="New" id="button_create_new">
                            <i class="fa fa-plus"></i><span class="hidden-xs">' . trans('admin.add_new') . '</span>
                            </a>
                        </div>
                        ';
        //=menu_right

        //menu_sort

        $optionSort = '';
        foreach ($arrSort as $key => $status) {
            $optionSort .= '<option  ' . (($sort_order == $key) ? "selected" : "") . ' value="' . $key . '">' . $status . '</option>';
        }

        $data['menu_sort'] = '
                       <div class="btn-group pull-left">
                        <div class="form-group">
                           <select class="form-control" id="order_sort">
                            ' . $optionSort . '
                           </select>
                         </div>
                       </div>

                       <div class="btn-group pull-left">
                           <a class="btn btn-flat btn-primary" title="Sort" id="button_sort">
                              <i class="fa fa-sort-amount-asc"></i><span class="hidden-xs"> ' . trans('admin.sort') . '</span>
                           </a>
                       </div>';

        $data['script_sort'] = "$('#button_sort').click(function(event) {
      var url = '" . route('admin_dbcumstomer.company.index') . "?sort_order='+$('#order_sort option:selected').val();
      $.pjax({url: url, container: '#pjax-container'})
    });";

    //=menu_sort

    //menu_search

        $data['menu_search'] = '
                <form action="' . route('admin_category.index') . '" id="button_search">
                   <div onclick="$(this).submit();" class="btn-group pull-right">
                           <a class="btn btn-flat btn-primary" title="Refresh">
                              <i class="fa  fa-search"></i><span class="hidden-xs"> ' . trans('admin.search') . '</span>
                           </a>
                   </div>
                   <div class="btn-group pull-right">
                         <div class="form-group">
                           <input type="text" name="keyword" class="form-control" placeholder="' . trans('db_customer.admin.search_place') . '" value="' . $keyword . '">
                         </div>
                   </div>
                </form>';
    //=menu_search

        $data['url_delete_item'] = route('admin_dbcumstomer.company.delete');

        return view('admin.screen.list')
            ->with($data);
    }

    /**
     * Form create new order in admin
     * @return [type] [description]
     */
    public function createCompany()
    {
        $data = [
            'title' => trans('db_customer.admin.add_new_company'),
            'sub_title' => '',
            'title_description' => trans('db_customer.admin.add_new_company_des'),
            'icon' => 'fa fa-plus',
            'languages' => $this->languages,
            'company' => [],
            'url_action' => route('admin_dbcumstomer.company.create'),
        ];
        return view('admin.screen.db_customer_company')
            ->with($data);
    }

    /**
    * Post create new order in admin
    * @return [type] [description]
    */
    public function postCreateCompany()
    {
        $data = request()->all();

        $dataInsert = [
            'company' => $data['company'],
            'treatment' => $data['treatment'],
            'indication' => $data['indication'],
            'phase' => $data['phase'],
            'characteristics' => $data['characteristics'],
            'focus' => $data['focus'],
            'portfolio' => $data['portfolio'],
            'technology' => $data['technology'],
            'website' => $data['website'],
            'additional_info' => $data['additional_info'],
            'notes' => $data['notes'],
        ];
        DBCustomerCompany::create($dataInsert);

        return redirect()->route('admin_dbcumstomer.company.index')->with('success', trans('db_customer.admin.create_success'));

    }
    /**
   * Form edit
   */
    public function editCompany($id)
    {
        $company = DBCustomerCompany::find($id);
        if ($company === null) {
            return 'no data';
        }
        $data = [
            'title' => trans('admin.edit'),
            'sub_title' => '',
            'title_description' => '',
            'icon' => 'fa fa-pencil-square-o',
            'languages' => $this->languages,
            'company' => $company,
            'url_action' => route('admin_dbcumstomer.company.edit', ['id' => $company['id']]),
        ];
        return view('admin.screen.db_customer_company')
            ->with($data);
    }

    /**
     * update status
    */
    public function editPostCompany($id)
    {
      $company = DBCustomerCompany::find($id);
      $data = request()->all();
      $dataUpdate = [
        'company' => $data['company'],
        'treatment' => $data['treatment'],
        'indication' => $data['indication'],
        'phase' => $data['phase'],
        'characteristics' => $data['characteristics'],
        'focus' => $data['focus'],
        'portfolio' => $data['portfolio'],
        'technology' => $data['technology'],
        'website' => $data['website'],
        'additional_info' => $data['additional_info'],
        'notes' => $data['notes'],
      ];
      $company->update($dataUpdate);
      return redirect()->route('admin_dbcumstomer.company.index')->with('success', trans('admin_dbcumstomer.edit_success'));
    }

    public function deleteCompany()
    {
      if (!request()->ajax()) {
        return response()->json(['error' => 1, 'msg' => 'Method not allow!']);
      } else {
          $ids = request('ids');
          $arrID = explode(',', $ids);
          DBCustomerCompany::destroy($arrID);
          return response()->json(['error' => 0, 'msg' => '']);
      }
    }

    public function importCompany()
    {
      $path = request()->import_company;
      $inputfile = fopen($path,"r");
      $output = [];
      fgetcsv($inputfile, 1000, ",");
      while (($data = fgetcsv($inputfile, 1000, ",")) !== FALSE) {
          $output[] = $data;
      }
      foreach ($output as $line) {
          $dataUpdate = [
            'company' => $line[0],
            'treatment' => $line[1],
            'indication' => $line[2],
            'phase' => $line[3],
            'characteristics' => $line[4],
            'focus' => $line[5],
            'portfolio' => $line[6],
            'technology' => $line[7],
            'website' => $line[8],
            'additional_info' => $line[9],
            'notes' => $line[10],
          ];
          DBCustomerCompany::create($dataUpdate);
      }
      echo json_encode(array('res' => 1));
      fclose($inputfile);
    }
   
    public function exportCompany()
    {
      $fields = DBCustomerCompany::get();
      $outputfile = fopen("./uploads/company.csv","w");
        $columns = array('Company', 'Treatment', 'Indication', 'Phase', 'Characteristics', 'Focus', 'Portfolio', 'Technology', 'Website', 'Additional Info', 'Notes');
        fputcsv($outputfile, $columns);
        foreach ($fields as $line) {
            fputcsv($outputfile, array($line->company, $line->treatment, $line->indication, $line->phase, $line->characteristics, $line->focus, $line->portfolio, $line->technology, $line->website, $line->additional_info, $line->notes));
        }
        fclose($outputfile);
      return redirect()->route('admin_dbcumstomer.company.index')->with('success', trans('admin_dbcumstomer.export_success'));
    }
}
