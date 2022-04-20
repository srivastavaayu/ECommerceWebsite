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
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;

class UserController extends Controller
{

  public function getProfile(Request $request)
  {
    return view('user/profile',
      [
        'name' => Auth::user() -> name,
        'email' => Auth::user() -> email,
        'phoneNumber' => Auth::user() -> phone_number,
        'username' => Auth::user() -> username
      ]
    );
  }

  public function postProfile(ProfileRequest $request)
  {
    $data = [];
    $user = User::getUser([['id', Auth::id()]]);
    if (!is_null($request -> FullNameInput))
    {
      $data['name'] = $request -> FullNameInput;
    }
    if (!is_null($request -> EmailInput))
    {
      $data['email'] = $request -> EmailInput;
    }
    if (!is_null($request -> PhoneNumberInput))
    {
      $data['phone_number'] = $request -> PhoneNumberInput;
    }
    if (!is_null($request -> UsernameInput))
    {
      $data['username'] = $request -> UsernameInput;
    }
    if (count($data) > 0)
    {
      User::setUser([['id', Auth::id()]], $data);
    }
    $user = User::getUser([['id', Auth::id()]]);
    Auth::setUser($user);
    $info = "Profile has been updated successfully!";
    return view('user/profile',
      [
        'name' => Auth::user() -> name,
        'email' => Auth::user() -> email,
        'phoneNumber' => Auth::user() -> phone_number,
        'username' => Auth::user() -> username,
        'info' => $info
      ]
    );
  }

  public function ordersHistory(Request $request)
  {
    if ($request -> has('orderId'))
    {
      $order = Order::getOrder([['id', $request -> orderId]]);
      $orderDetail = OrderDetail::getOrderDetails([['order_id', $order -> id]]) -> get();
      $products = [];
      foreach ($orderDetail as $orderItem)
      {
        $product = Product::getProduct([['id', $orderItem -> item_id]]);
        array_push($products, $product);
      }
      return view('user/order-history',
        [
          'user' => Auth::user(),
          'order' => $order,
          'items' => $orderDetail,
          'products' => $products
        ]
      );
    }
    $orders = Order::getOrders(
      [['user_id', Auth::id()]],
      null,
      null,
      ['updated_at', 'DESC']
    ) -> get();
    return view('user/orders-history', ['user' => Auth::user(), 'orders' => $orders]);
  }

  public function getUpdatePassword(Request $request)
  {
    return view('user/update-password');
  }

  public function postUpdatePassword(UpdatePasswordRequest $request)
  {
    $user = User::getUser([['id', Auth::id()]]);
    if (Hash::check($request -> CurrentPasswordInput, $user -> password))
    {
      User::setUser(
        [['id', Auth::id()]],
        ['password' => Hash::make($request -> PasswordInput)]
      );
      $info = "Password has been updated successfully!";
    }
    else
    {
      $info = "Current password is incorrect! Please check and try again.";
    }
    return view('user/update-password', ['info' => $info]);
  }

}
