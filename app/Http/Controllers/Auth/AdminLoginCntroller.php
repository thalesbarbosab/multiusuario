<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginCntroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin-web');
    }
    public function store(Request $request){
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $authOK = Auth::guard('admin-web')->attempt($credentials, $request->remember);

        $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
        if($authOK){
            return redirect()->intended(route('admin.index'));
        }
        return redirect()->back()->withInputs($request->only('email','remember'));
        /*
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        */
    }
    public function index(){
        return view('auth.admin-login');
    }
}
