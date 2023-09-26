<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Facedes\Hash;
// use Illuminate\Facedes\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Facedes\Session;

class AuthController extends Controller
{
    public function loadregister(){
        if(Auth::User()){
            $route = $this->redirectDash();
            return redirect ($route);
        }
        return view('register');
    }
    public function register(Request $request){
       $request->validate([
        'name' =>'string | required',
        'email' =>'string | required',
        'password' =>'string | required',
       ]);

       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $user->save();
       
       return back()->with('success','register successfull');
    }
    public function loadlogin(){
        if(Auth::User()){
            $route = $this->redirectDash();
            return redirect ($route);
        }
        return view('login');
    }
    public function login(Request $request){
        $request->validate([
            'email' =>'string | required',
            'password' =>'string | required',
           ]);
        $userCredential = $request->only('email','password');
        if(Auth::attempt($userCredential)){
            $route = $this->redirectDash();
            return redirect($route);
        }else{
            return back()->with('error','user name invalid');
        }   
    }
    public function redirectDash(){
        $redirect='';
        if(Auth::user() && Auth::user()->role == 1){
            $redirect = '/Admin/dashboard';
        }else{
            $redirect = '/User/dashboard';
        }
    }
}