<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{

  public function handle(Request $request)
  {
    $searchTerm = "";
    try
    {
      $products = Product::getProducts([['user_id', '!=', Auth::id()]]) -> get();
      $categories = Category::getCategories() -> get();
    }
    catch(Exception $e)
    {
      return view('404');
    }
    if ($request -> has('term'))
    {
      $searchTerm = $request -> term;
      try
      {
        $products = Product::getProducts(
          [['name', 'LIKE', '%'.$searchTerm.'%'], ['user_id', '!=', Auth::id()]]
        ) -> get();
        $categories = Category::getCategories(
          [['name', 'LIKE', '%'.$searchTerm.'%']]
        ) -> get();
      }
      catch(Exception $e)
      {
        return view('404');
      }
    }
    return view('shop/search',
      [
        'products' => $products,
        'categories' => $categories,
        'term' => $searchTerm
      ]
    );
  }

}
