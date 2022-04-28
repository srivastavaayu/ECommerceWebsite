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
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{

  public function cart()
  {
    try
    {
      $cart = Cart::getCarts([['user_id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('500');
    }
    $activeProducts = [];
    $inactiveProducts = [];
    $cartTotal = 0;
    $cartProducts = [];
    foreach ($cart as $cartItem) {
      $cartProducts[$cartItem -> product_id] = $cartItem -> quantity;
    }
    try {
      $products = Product::getProducts();
    }
    catch(Exception $e) {
      return view('500');
    }
    foreach ($products as $product) {
      if (in_array($product -> id, array_keys($cartProducts))) {
        if ($product -> is_archived == 0) {
          $cartTotal += (($product -> price) * $cartProducts[$product -> id]);
          array_push($activeProducts, $product);
        }
        else
        {
          array_push($inactiveProducts, $product);
        }
      }
    }

    // foreach ($cart as $cartItem)
    // {
    //   try
    //   {
    //     $product = Product::getProduct([['id', $cartItem -> product_id]]);
    //   }
    //   catch(Exception $e)
    //   {
    //     return view('500');
    //   }
    //   if ($product -> is_archived == 0)
    //   {
    //     $cartTotal += (($product -> price) * $cartItem -> quantity);
    //     array_push($activeProducts, $product);
    //   }
    //   else
    //   {
    //     array_push($inactiveProducts, $product);
    //   }
    // }
    return view('checkout/cart',
      [
        'cart' => $cart, 'activeProducts' => $activeProducts,
        'inactiveProducts' => $inactiveProducts,
        'cartTotal' => $cartTotal
      ]
    );
  }

  public function showCheckout(Request $request)
  {
    $user = Auth::user();
    try
    {
      $cart = Cart::getCarts([['user_id', Auth::id()]]);
      if (empty($cart)) {
        return view('404');
      }
    }
    catch(Exception $e)
    {
      return view('500');
    }
    $checkoutProducts = [];
    $cartTotal = 0;
    $cartProducts = [];
    foreach ($cart as $cartItem) {
      $cartProducts[$cartItem -> product_id] = $cartItem -> quantity;
    }
    try {
      $products = Product::getProducts();
    }
    catch(Exception $e) {
      return view('500');
    }
    foreach ($products as $product) {
      if (in_array($product -> id, array_keys($cartProducts))) {
        if ($product -> is_archived == 0) {
          $cartTotal += (($product -> price) * $cartProducts[$product -> id]);
          array_push($checkoutProducts, $product);
        }
      }
    }
    return view('checkout/checkout',
      [
        'user' => $user,
        'cart' => $cart,
        'products' => $checkoutProducts,
        'cartTotal' => $cartTotal
      ]
    );
  }

  public function storeCheckout(CheckoutRequest $request) {
    $user = Auth::user();
    try {
      $cart = Cart::getCarts([['user_id', Auth::id()]]);
      if (empty($cart)) {
        return view('404');
      }
    }
    catch(Exception $e) {
      return view('500');
    }
    $checkoutTotal = 0;
    $checkoutProducts = [];
    foreach ($cart as $cartItem) {
      $checkoutProducts[$cartItem -> product_id] = $cartItem -> quantity;
    }
    try {
      $products = Product::getProducts();
    }
    catch(Exception $e) {
      return view('500');
    }
    foreach ($products as $product) {
      if (in_array($product -> id, array_keys($checkoutProducts))) {
        if ($product -> is_archived == 0) {
          $checkoutTotal += (($product -> price) * $checkoutProducts[$product -> id]);
        }
      }
    }
    // DB::beginTransaction();
    $order = Order::addOrder(
      [
        'user_id' => Auth::id(),
        'address_line_1' => $request -> AddressLine1Input,
        'address_line_2' => $request -> AddressLine2Input,
        'city' => $request -> CityInput,
        'state' => $request -> StateInput,
        'country' => $request -> CountryInput,
        'pin_code' => $request -> PINCodeInput,
        'total' => $checkoutTotal
      ]
    );
    if (empty($order)) {
      // DB::rollback();
      return view('500');
    }
    foreach ($cart as $cartItem) {
      try {
        $product = Product::getProduct([['id', $cartItem -> product_id]]);
        if (empty($product)) {
          // DB::rollback();
          return view('404');
        }
      }
      catch(Exception $e) {
        // DB::rollback();
        return view('500');
      }
      if ($product -> is_archived == 0) {
        $orderDetail = OrderDetail::addOrderDetail(
          [
            'user_id' => Auth::id(),
            'order_id' => $order -> id,
            'item_id' => $cartItem -> product_id,
            'quantity' => $cartItem -> quantity
          ]
        );
        $product = Product::setProduct(
          [['id', $cartItem -> product_id]],
          [
            'quantity' => (($product -> quantity) - ($cartItem -> quantity)),
            'units_sold' => (($product -> units_sold) + ($cartItem -> quantity))
          ]
        );
        $cart = Cart::removeCart([['id', $cartItem -> id]]);
        // DB::commit();
      }
    }

    return redirect('/checkout/thank-you?orderId='.$order -> id);
  }

  public function thankYou(Request $request) {
    try {
      $order = Order::getOrder([['id', $request -> orderId]]);
      $user = User::getUser([['id', $order -> user_id]]);
      $orderItems = OrderDetail::getOrderDetails([['order_id', $order -> id]]);
      if (empty($order) || empty($user) || empty($orderItems)) {
        return view('404');
      }
    }
    catch(Exception $e) {
      return view('500');
    }
    $orderedProducts = [];
    $orderProducts = [];
    foreach ($orderItems as $orderItem) {
      array_push($orderProducts, $orderItem -> item_id);
    }
    try {
      $products = Product::getProducts();
    }
    catch(Exception $e)
    {
      return view('500');
    }
    foreach ($products as $product)
    {
      if (in_array($product -> id, $orderProducts)) {
        array_push($orderedProducts, $product);
      }
    }
    return view('checkout/thank-you',
      [
        'user' => $user,
        'order' => $order,
        'items' => $orderItems,
        'products' => $orderedProducts
      ]
    );
  }

}
