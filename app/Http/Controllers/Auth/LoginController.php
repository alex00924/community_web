<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\GeneralController;
use App\Models\ShopCountry;
use App\Models\EmailGroup;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use App\Http\Controllers\ChatkitController;

class LoginController extends GeneralController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';
    protected function redirectTo()
    {
        return '/';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }
    public function showLoginForm()
    {
        $email = $_GET['email'] ?? '';
        if (!empty($email)) {
            $result = EmailGroup::where('email',$email)->first();
            if (empty($result)) {
                $data = new EmailGroup;
                $data->email = $email;
                $data->save();
            }
        }

        if (Auth::user()) {
            return redirect()->route('home');
        }
        return view($this->templatePath . '.shop_login',
            array(
                'title' => trans('front.login'),
                'countries' => ShopCountry::getArray(),
                'email' => $email,
            )
        );
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            ]);

        if (\Auth::attempt([
            'email' => $request->email,
            'password' => $request->password])
        ){
            // $chatkit = new ChatkitController();
            // $chatkit->addChatkitSession($request);
            return redirect('/');
        }

        return $this->sendFailedLoginResponse($request);
    }
}
