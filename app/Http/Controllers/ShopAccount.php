<?php
#app/Http/Controller/ShopAccount.php
namespace App\Http\Controllers;

use App\Models\ShopCountry;
use App\Models\ShopOrder;
use App\Models\ShopOrderStatus;
use App\Models\ShopUser;
use App\Models\Network;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopAccount extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index user profile
     *
     * @return  [type]  [return description]
     */
    public function index()
    {
        $user = Auth::user();
        return view($this->templatePath . '.account.index')
            ->with(
                [
                'title' => trans('account.my_profile'),
                'user' => $user,
                'layout_page' => 'shop_profile',
                ]
            );
    }

    /**
     * Form Change password
     *
     * @return  [type]  [return description]
     */
    public function changePassword()
    {
        $user = Auth::user();
        $id = $user->id;
        return view($this->templatePath . '.account.change_password')
        ->with(
            [
                'title' => trans('account.change_password'),
                'user' => $user,
                'layout_page' => 'shop_profile',
            ]
        );
    }

    /**
     * Post change password
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function postChangePassword(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $dataUser = ShopUser::find($id);
        $password = $request->get('password');
        $password_old = $request->get('password_old');
        if (trim($password_old) == '') {
            return redirect()->back()
                ->with(
                    [
                        'password_old_error' => trans('account.password_old_required')
                    ]
                );
        } else {
            if (!\Hash::check($password_old, $dataUser->password)) {
                return redirect()->back()
                    ->with(
                        [
                            'password_old_error' => trans('account.password_old_notcorrect')
                        ]
                    );
            }
        }
        $messages = [
            'required' => trans('validation.required'),
        ];
        $v = Validator::make(
            $request->all(), 
            [
                'password_old' => 'required',
                'password' => 'required|string|min:6|confirmed',
            ],
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        ShopUser::updateInfo(['password' => bcrypt($password)], $id);

        return redirect()->route('member.index')
            ->with(['message' => trans('account.update_success')]);
    }

    /**
     * Form change info
     *
     * @return  [type]  [return description]
     */
    public function changeInfomation()
    {
        $user = Auth::user();
        $id = $user->id;
        $dataUser = ShopUser::find($id);
        return view($this->templatePath . '.account.change_infomation')
            ->with(
                [
                    'title' => trans('account.change_infomation'),
                    'dataUser' => $dataUser,
                    'layout_page' => 'shop_profile',
                    'countries' => ShopCountry::getArray(),
                ]
            );
    }

    /**
     * Process update info
     *
     * @param   Request  $request  [$request description]
     *
     * @return  [type]             [return description]
     */
    public function postChangeInfomation(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $data = request()->all();
        $dataUpdate = [
            'first_name'    => $data['first_name'],
            'address1'      => $data['address1'],
            'harvest_check' => $data['harvest_check'],
        ];
        $validate = [
            'first_name' => 'required|string|max:100',
            'address1'   => 'required|string|max:255',
        ];
        if(sc_config('customer_lastname')) {
            $validate['last_name']   = 'required|max:100';
            $dataUpdate['last_name'] = $data['last_name']??'';
        }
        if(sc_config('customer_address2')) {
            $validate['address2']   = 'required|max:100';
            $dataUpdate['address2'] = $data['address2']??'';
        }
        if(sc_config('customer_phone')) {
            $validate['phone']   = 'required|regex:/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/';
            $dataUpdate['phone'] = $data['phone']??'';
        }
        if(sc_config('customer_country')) {
            $validate['country']   = 'required|min:2';
            $dataUpdate['country'] = $data['country']??'';
        }
        if(sc_config('customer_postcode')) {
            $validate['postcode'] = 'nullable|min:5';
            $dataUpdate['postcode'] = $data['postcode']??'';
        }
        if(sc_config('customer_company')) {
            $validate['company']   = 'nullable';
            $dataUpdate['company'] = $data['company']??'';
        }   
        if(sc_config('customer_sex')) {
            $validate['sex'] = 'required';
            $dataUpdate['sex'] = $data['sex']??'';
        }   
        if(sc_config('customer_birthday')) {
            $validate['birthday'] = 'nullable|date|date_format:Y-m-d';
            if(!empty($data['birthday'])) {
                $dataUpdate['birthday'] = $data['birthday'];
            }
        } 
        if(sc_config('customer_group')) {
            $validate['group']   = 'nullable';
            $dataUpdate['group'] = $data['group']??1;
        }


        $messages = [
            'required' => trans('validation.required'),
        ];
        $v = Validator::make(
            $dataUpdate, 
            $validate, 
            $messages
        );
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        ShopUser::updateInfo($dataUpdate, $id);

        return redirect()->route('member.index')
            ->with(['message' => trans('account.update_success')]);
    }

    /**
     * Render order list
     * @return [type] [description]
     */
    public function orderList()
    {
        $user = Auth::user();
        $id = $user->id;
        $orders = ShopOrder::with('orderTotal')->where('user_id', $id)->sort()->get();
        $statusOrder = ShopOrderStatus::pluck('name', 'id')->all();
        return view($this->templatePath . '.account.order_list')
            ->with(
                [
                'title' => trans('account.order_list'),
                'user' => $user,
                'orders' => $orders,
                'statusOrder' => $statusOrder,
                'layout_page' => 'shop_profile',
                ]
            );
    }
    
    public function showNetworkLoginForm() {
        if (Auth::user()) {
            $user = Auth::user();
            $skills = Network::where('type', 'skill')->get();
            $needs = Network::where('type', 'need')->get();

            return view($this->templatePath . '.account.network_register', compact('user','skills','needs'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * 
     * @param Request $request  
     */
    public function network_register(Request $request)
    {
        $user = Auth::user();
        $background = $request->input('background');
        $sel_skills = $request->input('sel_skills');
        $sel_needs = $request->input('sel_needs');

        if ($background) {
            $user->background = $background;
        }
        
        if ($sel_skills) {
            $old_skills = json_decode($user->skill);
            
            foreach ($old_skills as $old_skill) {
                $result = Network::where('name',$old_skill)->first();
                if ($result) {
                    $network = Network::find($result['id']);
                    $network->count = $result['count'] - 1;

                    $network->save();
                }
            }

            $user->skill = json_encode($sel_skills);
            
            foreach ($sel_skills as $sel_skill) {
                $result = Network::where('name',$sel_skill)->first();
                
                if ($result) {
                    $network = Network::find($result['id']);
                    $network->count = $result['count'] + 1;

                    $network->save();
                } else {
                    $network        = new Network();
                    $network->name  = $sel_skill;
                    $network->type  = 'skill';
                    $network->count = 1;

                    $network->save();
                }
            }
        }
        
        if ($sel_needs) {
            $old_needs = json_decode($user->need);

            foreach ($old_needs as $old_need) {
                $result = Network::where('name',$old_need)->first();
                if ($result) {
                    $network = Network::find($result['id']);
                    $network->count = $result['count'] - 1;

                    $network->save();
                }
            }

            $user->need = json_encode($sel_needs);

            foreach ($sel_needs as $sel_need) {
                $result = Network::where('name',$sel_need)->first();
                if ($result) {
                    $network = Network::find($result['id']);
                    $network->count = $result['count'] + 1;

                    $network->save();
                } else {
                    $network        = new Network();
                    $network->name  = $sel_need;
                    $network->type  = 'need';
                    $network->count = 1;

                    $network->save();
                }
            }
        }

        $user->save();

        return redirect('/member/register.html');
    }

    /**
     * 
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function network_check(Request $request)
    {
        $status = $request->status;
        $user = Auth::user();

        if ($status == 'true') {
            $user->network_status = 'on';
        } else {
            $user->network_status = 'off';
        }

        $user->save();

        return response()->json(['result' => 'success']);
    }
}
