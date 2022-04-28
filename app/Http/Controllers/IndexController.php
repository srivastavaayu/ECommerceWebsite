<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
  public function handle()
  {
    try
    {
      $products = Product::getProducts(
        [['is_archived', 0], ['user_id', '!=', Auth::id()]]
      );
      $categories = Category::getCategories();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    if(Auth::check())
    {
      return view('index',
        [
          'name' => Auth::user() -> name,
          'products' => $products,
          'categories' => $categories
        ]
      );
    }
    return view('index', ['products' => $products, 'categories' => $categories]);
  }
}
