<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{

  public function handle(Request $request) {
    if($request -> isMethod("POST")) {
      $validator = Validator::make($request -> all(), [
        'CurrentPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
        'PasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
        'ReenterPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'same:PasswordInput']
      ]);

      if($validator -> fails()) {
        return redirect('/user/update-password') -> withErrors($validator) -> withInput();
      }
      else {
        $user = User::where('id', Auth::id()) -> get();
        if (Hash::check($request -> CurrentPasswordInput, $user[0] -> password)) {
          $user = User::find(Auth::id());
          $user -> password = Hash::make($request -> PasswordInput);
          $user -> save();
          $info = "Password has been updated successfully!";
        }
        else {
          $info = "Current password is incorrect! Please check and try again.";
        }
        return view('update-password', ['info' => $info]);
      }
    }
    else {
      return view('update-password');
    }
  }

}
