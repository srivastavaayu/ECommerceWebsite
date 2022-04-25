<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{

  public function showRegister(Request $request)
  {
    return view('auth/register');
  }

  public function storeRegister(RegisterRequest $request)
  {
    try
    {
      User::addUser(
        [
          'name' => $request -> FullNameInput,
          'email' => $request -> EmailInput,
          'phone_number' => $request -> PhoneNumberInput,
          'username' => $request -> UsernameInput,
          'password' => Hash::make($request -> PasswordInput)
        ]
      );
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/login');
  }

  public function showLogin(Request $request)
  {
    return view('auth/login');
  }

  public function storeLogin(LoginRequest $request)
  {
    try
    {
      $users = User::getUser([['username', $request -> UsernameInput]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    if ($users != null)
    {
      if (Hash::check($request -> PasswordInput, $users -> password))
      {
        Auth::loginUsingId($users -> id);
        return redirect('/');
      }
    }
    $info = "Username/Password does not match! Please try again.";
    return view('auth/login', ['info' => $info]);
  }

  public function logout()
  {
    Auth::logout();
    return redirect('/');
  }

}
