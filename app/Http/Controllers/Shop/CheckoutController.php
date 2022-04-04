<?php

namespace App\Http\Controllers\Shop;

use App\User;
use App\Product;
use App\Category;
use App\Cart;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{

  public function cart() {
    $cart = Cart::where('user_id', Auth::id()) -> get();
    $products = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem) {
      $product = Product::find($cartItem -> product_id);
      $cartTotal += (($product -> price) * $cartItem -> quantity);
      array_push($products, $product);
    }
    return view('checkout/cart', ['cart' => $cart, 'products' => $products, 'cartTotal' => $cartTotal]);
  }

  public function checkout(Request $request) {
    $user = Auth::user();
    $cart = Cart::where('user_id', Auth::id()) -> get();
    $products = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem) {
      $product = Product::find($cartItem -> product_id);
      $cartTotal += (($product -> price) * $cartItem -> quantity);
      array_push($products, $product);
    }
    if ($request -> isMethod('POST')) {
      $validator = Validator::make($request -> all(), [
        'AddressLine1Input' => ['required'],
        'AddressLine2Input' => ['required'],
        'CityInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'StateInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'CountryInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
        'PINCodeInput' => ['required', 'regex:/[A-Za-z0-9 ]+/u'],
      ]);

      if($validator -> fails()) {
        return redirect('/register') -> withErrors($validator) -> withInput();
      }

      $order = new Order;
      $order -> user_id = Auth::id();
      $order -> address_line_1 = $request -> AddressLine1Input;
      $order -> address_line_2 = $request -> AddressLine2Input;
      $order -> city = $request -> CityInput;
      $order -> state = $request -> StateInput;
      $order -> country = $request -> CountryInput;
      $order -> pin_code = $request -> PINCodeInput;
      $order -> total = $cartTotal;
      $order -> save();

      foreach ($cart as $cartItem) {
        $orderDetail = new OrderDetail;
        $orderDetail -> user_id = Auth::id();
        $orderDetail -> order_id = $order -> id;
        $orderDetail -> item_id = $cartItem -> product_id;
        $orderDetail -> quantity = $cartItem -> quantity;
        $orderDetail -> save();
        $product = Product::find($cartItem -> product_id);
        $product -> quantity = ($product -> quantity - $cartItem -> quantity);
        $product -> save();
        $cartItem -> delete();
      }

      return redirect('/checkout/thank-you?orderId='.$order -> id);
    }
    return view('checkout/checkout', ['user' => $user, 'cart' => $cart, 'products' => $products, 'cartTotal' => $cartTotal]);
  }

  public function thankYou(Request $request) {
    $order = Order::find($request -> orderId);
    $user = User::find($order -> user_id);
    $orderItems = OrderDetail::where('order_id', $order -> id) -> get();
    $products = [];
    foreach ($orderItems as $orderItem) {
      $product = Product::find($orderItem -> item_id);
      array_push($products, $product);
    }
    return view('checkout/thank-you', ['user' => $user, 'order' => $order, 'items' => $orderItems, 'products' => $products]);
  }

}
