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
      $products = Product::getProducts();
      $categories = Category::getCategories();
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
        $products = Product::getProductsWithSearch($searchTerm, 0);
        $categories = Category::getCategoriesWithSearch($searchTerm);
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
