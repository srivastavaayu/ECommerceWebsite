<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
  public function handle() {
    $products = Product::all();
    $categories = Category::all();
    if(Auth::check()) {
      return view('index', ['name' => Auth::user() -> name, 'products' => $products, 'categories' => $categories]);
    }
    return view('index', ['products' => $products, 'categories' => $categories]);
  }
}
