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
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{

  public function cart()
  {
    try
    {
      $cart = Cart::getCarts([['user_id', Auth::id()]]) -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    $activeProducts = [];
    $inactiveProducts = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem)
    {
      try
      {
        $product = Product::getProduct([['id', $cartItem -> product_id]]);
      }
      catch(Exception $e)
      {
        return view('404');
      }
      if ($product -> is_archived == 0)
      {
        $cartTotal += (($product -> price) * $cartItem -> quantity);
        array_push($activeProducts, $product);
      }
      else
      {
        array_push($inactiveProducts, $product);
      }
    }
    return view('checkout/cart',
      [
        'cart' => $cart, 'activeProducts' => $activeProducts,
        'inactiveProducts' => $inactiveProducts,
        'cartTotal' => $cartTotal
      ]
    );
  }

  public function getCheckout(Request $request)
  {
    $user = Auth::user();
    try
    {
      $cart = Cart::getCarts([['user_id', Auth::id()]]) -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    $products = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem)
    {
      try
      {
        $product = Product::getProduct([['id', $cartItem -> product_id]]);
      }
      catch(Exception $e)
      {
        return view('404');
      }
      if ($product -> is_archived == 0)
      {
        $cartTotal += (($product -> price) * $cartItem -> quantity);
        array_push($products, $product);
      }
    }
    return view('checkout/checkout',
      [
        'user' => $user,
        'cart' => $cart,
        'products' => $products,
        'cartTotal' => $cartTotal
      ]
    );
  }

  public function postCheckout(CheckoutRequest $request)
  {
    $user = Auth::user();
    try
    {
      $cart = Cart::getCarts([['user_id', Auth::id()]]) -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    $products = [];
    $cartTotal = 0;
    foreach ($cart as $cartItem)
    {
      try
      {
        $product = Product::getProduct([['id', $cartItem -> product_id]]);
      }
      catch(Exception $e)
      {
        return view('404');
      }
      if ($product -> is_archived == 0)
      {
        $cartTotal += (($product -> price) * $cartItem -> quantity);
        array_push($products, $product);
      }
    }

    $order = Order::addOrder(
      [
        'user_id' => Auth::id(),
        'address_line_1' => $request -> AddressLine1Input,
        'address_line_2' => $request -> AddressLine2Input,
        'city' => $request -> CityInput,
        'state' => $request -> StateInput,
        'country' => $request -> CountryInput,
        'pin_code' => $request -> PINCodeInput,
        'total' => $cartTotal
      ]
    );

    foreach ($cart as $cartItem)
    {
      try
      {
        $product = Product::getProduct([['id', $cartItem -> product_id]]);
      }
      catch(Exception $e)
      {
        return view('404');
      }
      if ($product -> is_archived == 0)
      {
        OrderDetail::addOrderDetail(
          [
            'user_id' => Auth::id(),
            'order_id' => $order -> id,
            'item_id' => $cartItem -> product_id,
            'quantity' => $cartItem -> quantity
          ]
        );
        Product::setProduct(
          [['id', $cartItem -> product_id]],
          [
            'quantity' => ($product -> quantity - $cartItem -> quantity),
            'units_sold' => ($product -> units_sold - $cartItem -> quantity)
          ]
        );
        Cart::removeCart([['id', $cartItem -> id]]);
      }
    }

    return redirect('/checkout/thank-you?orderId='.$order -> id);
  }

  public function thankYou(Request $request)
  {
    try
    {
      $order = Order::getOrder([['id', $request -> orderId]]);
      $user = User::getUser([['id', $order -> user_id]]);
      $orderItems = OrderDetail::getOrderDetails([['order_id', $order -> id]]) -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    $products = [];
    foreach ($orderItems as $orderItem)
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
    return view('checkout/thank-you',
      [
        'user' => $user,
        'order' => $order,
        'items' => $orderItems,
        'products' => $products
      ]
    );
  }

}
