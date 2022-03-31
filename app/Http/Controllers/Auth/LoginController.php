<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

  public function handle(Request $request) {
    if($request -> isMethod("POST")) {
      $validator = Validator::make($request -> all(), [
        'UsernameInput' => ['required'],
        'PasswordInput' => ['required']
      ], ['UsernameInput.required' => 'Username is required!', 'PasswordInput.required' => 'Password is required!']);

      if($validator -> fails()) {
        return redirect('/login') -> withErrors($validator) -> withInput();
      }
      $users = User::where('username', $request -> UsernameInput) -> get();
      if ($users -> count()) {
        if (Hash::check($request -> PasswordInput, $users[0] -> password)) {
          // Auth::loginUsingId($users[0] -> id);
          Auth::loginUsingId($users[0] -> id);
          return redirect('/');
        }
        else {
          $info = "Incorrect password! Please try again.";
        }
      }
      else {
        $info = "Username does not exists! Please try again.";
      }
      return view('auth/login', ['info' -> $info]);
    }
    return view('auth/login');
  }

}
