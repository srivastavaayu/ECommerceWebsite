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

  public $sortBehavior = 'none';
  public $sortField = 'id';
  public $sortDirection = 'ASC';

  public function products(Request $request) {
    if ($request -> has('sort')) {
      switch ($request -> sort) {
        case "priceASC":
          $this -> sortBehavior = 'priceASC';
          $this -> sortField = 'price';
          $this -> sortDirection = 'ASC';
          break;
        case "priceDESC":
          $this -> sortBehavior = 'priceDESC';
          $this -> sortField = 'price';
          $this -> sortDirection = 'DESC';
          break;
        case "ratingASC":
          $this -> sortBehavior = 'ratingASC';
          $this -> sortField = 'rating';
          $this -> sortDirection = 'ASC';
          break;
        case "ratingDESC":
          $this -> sortBehavior = 'ratingDESC';
          $this -> sortField = 'rating';
          $this -> sortDirection = 'DESC';
          break;
        default:
          $this -> sortBehavior = 'none';
          $this -> sortField = 'id';
          $this -> sortDirection = 'ASC';
          break;
      }
    }
    if ($request -> isMethod('POST')) {

    }
    $products = Product::where('is_archived', 0) -> orderBy($this -> sortField, $this -> sortDirection) -> simplePaginate(3);
    return view('shop/products',['products' => $products, 'sortBehavior' => $this -> sortBehavior]);
  }

  public function product(Request $request, $id) {
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
