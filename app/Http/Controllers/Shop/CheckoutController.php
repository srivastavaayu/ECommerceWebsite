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
    $cart = Cart::getCarts([['user_id', Auth::id()]]) -> get();
    $activeProducts = [];
    $inactiveProducts = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem) {
      $product = Product::getProduct([['id', $cartItem -> product_id]]);
      if ($product -> is_archived == 0) {
        $cartTotal += (($product -> price) * $cartItem -> quantity);
        array_push($activeProducts, $product);
      }
      else {
        array_push($inactiveProducts, $product);
      }
    }
    return view('checkout/cart', ['cart' => $cart, 'activeProducts' => $activeProducts, 'inactiveProducts' => $inactiveProducts, 'cartTotal' => $cartTotal]);
  }

  public function checkout(Request $request) {
    $user = Auth::user();
    $cart = Cart::getCarts([['user_id', Auth::id()]]) -> get();
    $products = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem) {
      $product = Product::getProduct([['id', $cartItem -> product_id]]);
      if ($product -> is_archived == 0){
        $cartTotal += (($product -> price) * $cartItem -> quantity);
        array_push($products, $product);
      }
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

      $order = Order::addOrder(['user_id' => Auth::id(), 'address_line_1' => $request -> AddressLine1Input, 'address_line_2' => $request -> AddressLine2Input, 'city' => $request -> CityInput, 'state' => $request -> StateInput, 'country' => $request -> CountryInput, 'pin_code' => $request -> PINCodeInput, 'total' => $cartTotal]);

      foreach ($cart as $cartItem) {
        $product = Product::getProduct([['id', $cartItem -> product_id]]);
        if ($product -> is_archived == 0) {
          OrderDetail::addOrderDetail(['user_id' => Auth::id(), 'order_id' => $order -> id, 'item_id' => $cartItem -> product_id, 'quantity' => $cartItem -> quantity]);
          Product::setProduct([['id', $cartItem -> product_id]], [['quantity', ($product -> quantity - $cartItem -> quantity)]]);
          Cart::removeCart([['id', $cartItem -> id]]);
        }
      }

      return redirect('/checkout/thank-you?orderId='.$order -> id);
    }
    return view('checkout/checkout', ['user' => $user, 'cart' => $cart, 'products' => $products, 'cartTotal' => $cartTotal]);
  }

  public function thankYou(Request $request) {
    $order = Order::getOrder([['id', $request -> orderId]]);
    $user = User::getUser([['id', $order -> user_id]]);
    $orderItems = OrderDetail::getOrderDetails([['order_id', $order -> id]]) -> get();
    $products = [];
    foreach ($orderItems as $orderItem) {
      $product = Product::getProduct([['id', $orderItem -> item_id]]);
      array_push($products, $product);
    }
    return view('checkout/thank-you', ['user' => $user, 'order' => $order, 'items' => $orderItems, 'products' => $products]);
  }

}
