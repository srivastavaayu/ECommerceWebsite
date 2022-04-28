<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
    DB::beginTransaction();
    try
    {
      User::addUser(
        [
          'name' => $request -> fullNameInput,
          'email' => $request -> emailInput,
          'phone_number' => $request -> phoneNumberInput,
          'username' => $request -> usernameInput,
          'password' => Hash::make($request -> passwordInput)
        ]
      );
      DB::commit();
    }
    catch(Exception $e)
    {
      DB::rollback();
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
      $users = User::getUser([['username', $request -> usernameInput]]);
    }
    catch(Exception $e)
    {
      return view('500');
    }
    if ($users != null)
    {
      if (Hash::check($request -> passwordInput, $users -> password))
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
