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

  public function showProducts(Request $request)
  {
    if ($request -> has('sort'))
    {
      switch ($request -> sort)
      {
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
    try
    {
      $products = Product::getProducts(
        [['is_archived', 0], ['user_id', '!=', Auth::id()]],
        null,
        null,
        [$this -> sortField, $this -> sortDirection]
      ) -> simplePaginate(3);
    }
    catch(Exception $e)
    {
      return view('404');
    }
      return view('shop/products',
      [
        'products' => $products,
        'sortBehavior' => $this -> sortBehavior
      ]
    );
  }

  public function showProduct($id)
  {
    try
    {
      $product = Product::getProduct([['id', $id]]);
      $category = Category::getCategory([['id', $product -> category_id]]);
      $cart = Cart::getCart([['product_id', $id], ['user_id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return view('shop/product',
      [
        'product' => $product,
        'category' => $category,
        'cart' => $cart
      ]
    );
  }

  public function addToCart($id)
  {
    try
    {
      Cart::addCart(
        [
          'user_id' => Auth::id(),
          'product_id' => $id,
          'quantity' => 1
        ]
      );
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/shop/product/'.$id);
  }

  public function removeFromCart($id)
  {
    try
    {
      Cart::removeCart([['product_id', $id], ['user_id', Auth::id()]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/shop/product/'.$id);
  }

  public function setCartQuantity(Request $request, $id)
  {
    try
    {
      $cart = Cart::getCart([['product_id', $id], ['user_id', Auth::id()]]);
      $product = Product::getProduct([['id', $id]]);
    }
    catch(Exception $e)
    {
      return view('404');
    }
    if ($request -> quantity > $product -> quantity)
    {
      Cart::setCart(
        [['product_id', $id], ['user_id', Auth::id()]],
        ['quantity' => $product -> quantity]
      );
    }
    else if($request -> quantity < 1)
    {
      Cart::setCart(
        [['product_id', $id], ['user_id', Auth::id()]],
        ['quantity' => 1]
      );
    }
    else {
      Cart::setCart(
        [['product_id', $id], ['user_id', Auth::id()]],
        ['quantity' => $request -> quantity]
      );
    }
    return redirect('/shop/product/'.$id);
  }

  public function increaseCartQuantity($id)
  {
    try
    {
      $cart = Cart::getCart([['product_id', $id], ['user_id', Auth::id()]]);
      Cart::setCart(
        [['product_id', $id], ['user_id', Auth::id()]],
        ['quantity' => ($cart -> quantity + 1)]
      );
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/shop/product/'.$id);
  }

  public function decreaseCartQuantity($id)
  {
    try
    {
      $cart = Cart::getCart([['product_id', $id], ['user_id', Auth::id()]]);
      Cart::setCart(
        [['product_id', $id], ['user_id', Auth::id()]],
        ['quantity' => ($cart -> quantity - 1)]
      );
    }
    catch(Exception $e)
    {
      return view('404');
    }
    return redirect('/shop/product/'.$id);
  }

  public function setRating(Request $request, $id)
  {
    Product::setProduct([['id', $id]], ['rating' => $request -> rating]);
    return redirect('/shop/product/'.$id);
  }

}
