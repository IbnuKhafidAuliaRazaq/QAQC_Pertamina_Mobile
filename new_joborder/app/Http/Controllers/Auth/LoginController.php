<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Users;
use App\DeviceToken;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated(Request $request, $user)
    {
        
        if ( $user->level == 1) {// do your magic here
            return redirect('/user');
        }else if($user->level == 2){
            return redirect('/leader');
        }else if($user->level == 3){
            return redirect('/inspector');
        }else if($user->level == 4){
            return redirect('/manager');
        }
    }

    public function apiLogin(Request $request){

        $validate = \Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'token' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'errors' => $validate->errors()
            ]);
        }

        $users = Users::where('username', $request->username)->get();
        if(count($users) > 0){
            if(password_verify($request->password, $users[0]->password)){
                
                $token = new DeviceToken();
                $token->user_id = $users[0]->id;
                $token->token = $request->token;
                $token->save();

                return response()->json([
                    'data' => $users[0],
                    'token_id' => $token->id
                ]);
            }else{
                return response()->json([
                    'errors' => [
                        'message' => 'password does not match'
                    ]
                ]);
            }
        }else{
            return response()->json([
                'errors' => [
                    'message' => 'username not found'
                ]
            ]);
        }

        return response()->json([
            'data' => [
                'username' => $request->username,
                'password' => $request->password
            ]
        ]);
    }

    public function apiLogout($device_token){
        $token = DeviceToken::find($device_token);
        $token->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
