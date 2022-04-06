<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

  public function handle(Request $request)
  {
    $searchTerm = "";
    $products = Product::getProducts() -> get();
    $categories = Category::getCategories() -> get();
    if ($request -> has('term'))
    {
      $searchTerm = $request -> term;
      $products = Product::getProducts([['name', 'LIKE', '%'.$searchTerm.'%']]) -> get();
      $categories = Category::getCategories([['name', 'LIKE', '%'.$searchTerm.'%']]) -> get();
    }
    return view('shop/search', ['products' => $products, 'categories' => $categories, 'term' => $searchTerm]);
  }

}
