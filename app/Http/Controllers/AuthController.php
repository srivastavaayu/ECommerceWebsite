<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

  public function register(Request $request)
  {
    if($request -> isMethod("POST"))
    {
      $validator = Validator::make($request -> all(),
        [
          'FullNameInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
          'EmailInput' => ['required', 'regex:/\S+@\S+\.\S+/u', 'unique:users,email'],
          'PhoneNumberInput' => ['required', 'regex:/^[0-9]{10}$/u', 'unique:users,phone_number'],
          'UsernameInput' => ['required', 'regex:/[A-Za-z0-9]+/u', 'unique:users,username'],
          'PasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
          'ReenterPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'same:PasswordInput'],
        ]
      );

      if($validator -> fails())
      {
        return redirect('/register') -> withErrors($validator) -> withInput();
      }
      User::addUser(['name' => $request -> FullNameInput, 'email' => $request -> EmailInput, 'phone_number' => $request -> PhoneNumberInput, 'username' => $request -> UsernameInput, 'password' => Hash::make($request -> PasswordInput)]);
      return redirect('/login');
    }
    return view('auth/register');
  }

  public function login(Request $request)
  {
    if($request -> isMethod("POST")) {
      $validator = Validator::make($request -> all(),
        [
          'UsernameInput' => ['required'],
          'PasswordInput' => ['required']
        ],
        ['UsernameInput.required' => 'Username is required!',
        'PasswordInput.required' => 'Password is required!'
        ]
      );

      if($validator -> fails())
      {
        return redirect('/login') -> withErrors($validator) -> withInput();
      }
      $users = User::getUsers([['username', $request -> UsernameInput]]) -> get();
      if ($users -> count())
      {
        if (Hash::check($request -> PasswordInput, $users[0] -> password))
        {
          Auth::loginUsingId($users[0] -> id);
          return redirect('/');
        }
        else
        {
          $info = "Incorrect password! Please try again.";
        }
      }
      else
      {
        $info = "Username does not exists! Please try again.";
      }
      return view('auth/login', ['info' -> $info]);
    }
    return view('auth/login');
  }

  public function logout()
  {
    Auth::logout();
    return redirect('/');
  }

}
