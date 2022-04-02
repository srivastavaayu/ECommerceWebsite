<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

  public function profile(Request $request) {
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

  public function ordersHistory(Request $request) {
    if ($request -> has('orderId')) {
      $order = Order::find($request -> orderId);
      $orderDetail = OrderDetail::where('order_id', $order -> id) -> get();
      $products = [];
      foreach ($orderDetail as $orderItem) {
        $product = Product::find($orderItem -> item_id);
        array_push($products, $product);
      }
      return view('user/order-history', ['user' => Auth::user(), 'order' => $order, 'items' => $orderDetail, 'products' => $products]);
    }
    $orders = Order::where('user_id', Auth::id()) -> orderBy('updated_at', 'DESD') -> get();
    return view('user/orders-history', ['user' => Auth::user(), 'orders' => $orders]);
  }

  public function updatePassword(Request $request) {
    if($request -> isMethod("POST")) {
      $validator = Validator::make($request -> all(), [
        'CurrentPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
        'PasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u'],
        'ReenterPasswordInput' => ['required', 'regex:/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/u', 'same:PasswordInput']
      ]);

      if($validator -> fails()) {
        return redirect('/user/update-password') -> withErrors($validator) -> withInput();
      }
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
      return view('user/update-password', ['info' => $info]);
    }
    return view('user/update-password');
  }

}
