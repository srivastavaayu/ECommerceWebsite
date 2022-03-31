<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

  public function handle(Request $request) {
    if($request -> isMethod("POST")) {
      $validator = Validator::make($request -> all(), [
        'FullNameInput' => ['nullable', 'regex:/[A-Za-z0-9 ]+/u'],
        'EmailInput' => ['nullable', 'regex:/\S+@\S+\.\S+/u', Rule::unique('users', 'email')->ignore(Auth::id())],
        'PhoneNumberInput' => ['nullable', 'regex:/^[0-9]{10}$/u', Rule::unique('users', 'phone_number')->ignore(Auth::id())],
        'UsernameInput' => ['nullable', 'regex:/[A-Za-z0-9]+/u', Rule::unique('users', 'username')->ignore(Auth::id())],
      ]);

      if($validator -> fails()) {
        return redirect('/user/profile') -> withErrors($validator) -> withInput();
      }
      $user = User::find(Auth::id());
      if (!is_null($request -> FullNameInput)) {
        $user -> name = $request -> FullNameInput;
      }
      if (!is_null($request -> EmailInput)) {
        $user -> email = $request -> EmailInput;
      }
      if (!is_null($request -> PhoneNumberInput)) {
        $user -> phone_number = $request -> PhoneNumberInput;
      }
      if (!is_null($request -> UsernameInput)) {
        $user -> username = $request -> UsernameInput;
      }
      $user -> save();
      Auth::setUser($user);
      $info = "Profile has been updated successfully!";
      return view('user/profile', ['name' => Auth::user() -> name, 'email' => Auth::user() -> email, 'phoneNumber' => Auth::user() -> phone_number, 'username' => Auth::user() -> username, 'info' => $info]);
    }
    return view('user/profile', ['name' => Auth::user() -> name, 'email' => Auth::user() -> email, 'phoneNumber' => Auth::user() -> phone_number, 'username' => Auth::user() -> username]);
  }

}
