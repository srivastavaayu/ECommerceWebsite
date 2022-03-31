<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use App\Category;
use App\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

  public function handle(Request $request, $id) {
    if ($request -> isMethod('POST')) {

    }
    $product = Product::find($id);
    $category = Category::find($product -> category_id);
    $cart = Cart::where([['product_id', $id], ['user_id', Auth::id()]]) -> firstOr(function () {
      return null;
    });
    return view('shop/product', ['product' => $product, 'category' => $category, 'cart' => $cart]);
  }

  public function addToCart(Request $request, $id) {
    $cart = new Cart;
    $cart -> user_id = Auth::id();
    $cart -> product_id = $id;
    $cart -> quantity = 1;
    $cart -> save();
    return redirect('/shop/product/'.$id);
  }

  public function removeFromCart(Request $request, $id) {
    $cart = Cart::where([['product_id', $id], ['user_id', Auth::id()]]) -> first();
    $cart -> delete();
    return redirect('/shop/product/'.$id);
  }

  public function increaseCartQuantity(Request $request, $id) {
    $cart = Cart::where([['product_id', $id], ['user_id', Auth::id()]]) -> first();
    $cart -> quantity = ($cart -> quantity) + 1;
    $cart -> save();
    return redirect('/shop/product/'.$id);
  }

  public function decreaseCartQuantity(Request $request, $id) {
    $cart = Cart::where([['product_id', $id], ['user_id', Auth::id()]]) -> first();
    $cart -> quantity = ($cart -> quantity) - 1;
    $cart -> save();
    return redirect('/shop/product/'.$id);
  }

}
