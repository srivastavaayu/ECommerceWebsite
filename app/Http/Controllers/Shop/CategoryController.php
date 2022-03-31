<?php

namespace App\Http\Controllers\Shop;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function handle(Request $request, $id) {
      $category = Category::find($id);
      $products = Product::where('category_id', $id) -> simplePaginate(3);
      return view('shop/category', ['category' => $category, 'products' => $products]);
    }

}
