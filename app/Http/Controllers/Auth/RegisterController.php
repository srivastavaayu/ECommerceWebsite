<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  // protected function validator(array $data)
  // {
  //     return Validator::make($data, [
  //         'name' => 'required|string|max:255',
  //         'email' => 'required|string|email|max:255|unique:users',
  //         'password' => 'required|string|min:6|confirmed',
  //     ]);
  // }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  // protected function create(array $data)
  // {
  //     return User::create([
  //         'name' => $data['name'],
  //         'email' => $data['email'],
  //         'password' => bcrypt($data['password']),
  //     ]);
  // }

  public function handle(Request $request) {
    if($request -> isMethod("POST")) {
      $validator = Validator::make($request -> all(), [
        'FullNameInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'EmailInput' => ['required', 'regex:/\S+@\S+\.\S+/u', 'unique:users,email'],
        'PhoneNumberInput' => ['required', 'regex:/^[0-9]{10}$/u', 'unique:users,phone_number'],
        'UsernameInput' => ['required', 'regex:/[A-Za-z0-9]+/u', 'unique:users,username'],
        'PasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
        'ReenterPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'same:PasswordInput'],
      ]);

      if($validator -> fails()) {
        return redirect('/register') -> withErrors($validator) -> withInput();
      }
      $user = new User;
      // User::addUser(['name' => $request -> FullNameInput, 'email' => $request -> EmailInput, 'phone_number' => $request -> PhoneNumberInput, 'username' => $request -> UsernameInput, 'password' => Hash::make($request -> PasswordInput)]);
      $user -> name = $request -> FullNameInput;
      $user -> email = $request -> EmailInput;
      $user -> phone_number = $request -> PhoneNumberInput;
      $user -> username = $request -> UsernameInput;
      $user -> password = Hash::make($request -> PasswordInput);
      $user -> save();
      return redirect('/login');
    }
    return view('auth/register');
  }

}
