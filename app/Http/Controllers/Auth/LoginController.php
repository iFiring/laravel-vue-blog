<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
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
    protected $redirectTo = '/blog/#/admin'; // 登录后重定向的地址

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'email' => 'required|max:32|uinque:users',
            'password' => 'required|confirmed|min:8'
        ]);
    }

    protected function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:32',
            'password' => 'required|min:8'
        ]);
        if ($validator->passes()) {
            if (auth()->attempt(array(
                'email' => $request->input('email'),
                'password' => $request->input('password')),true)) {
                return response()->json('success');
            }
            return response()->json(['error'=>[
                'email' => 'Sorry, Username and password is incorrect.'
            ]]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    protected function logout()
    {
        Auth::logout();
        return response()->json('success');
    }
}
