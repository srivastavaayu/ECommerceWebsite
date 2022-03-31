<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

  public function handle(Request $request) {
    $searchTerm = "";
    $products = Product::all();
    $categories = Category::all();
    if ($request -> has('term')) {
      $searchTerm = $request -> term;
      $products = Product::where('name', 'LIKE', '%'.$searchTerm.'%') -> orWhere('description', 'LIKE', '%'.$searchTerm.'%') -> get();
      $categories = Category::where('name', 'LIKE', '%'.$searchTerm.'%') -> orWhere('description', 'LIKE', '%'.$searchTerm.'%') -> get();
    }
    return view('shop/search', ['products' => $products, 'categories' => $categories, 'term' => $searchTerm]);
  }

}
