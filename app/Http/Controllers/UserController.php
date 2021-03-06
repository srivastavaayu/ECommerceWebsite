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

  public function showProfile(Request $request)
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

  public function storeProfile(ProfileRequest $request)
  {
    $data = [];
    try
    {
      $user = User::getUser([['id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
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
      try
      {
        User::setUser([['id', Auth::id()]], $data);
      }
      catch(Exception $e)
      {
        return view('404');
      }
    }
    try
    {
      $user = User::getUser([['id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
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
      try
      {
        $order = Order::getOrder([['id', $request -> orderId]]);
        $orderDetail = OrderDetail::getOrderDetails([['order_id', $order -> id]]) -> get();
      }
      catch(Exception $e)
      {
        return view('404');
      }
      $products = [];
      foreach ($orderDetail as $orderItem)
      {
        try
        {
          $product = Product::getProduct([['id', $orderItem -> item_id]]);
        }
        catch(Exception $e)
        {
          return view('404');
        }
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
    try
    {
      $orders = Order::getOrders(
        [['user_id', Auth::id()]],
        null,
        null,
        ['updated_at', 'DESC']
      ) -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return view('user/orders-history', ['user' => Auth::user(), 'orders' => $orders]);
  }

  public function showUpdatePassword(Request $request)
  {
    return view('user/update-password');
  }

  public function storeUpdatePassword(UpdatePasswordRequest $request)
  {
    try
    {
      $user = User::getUser([['id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
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
