<?php

namespace App\Http\Controllers\Shop;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{

  public function handle(Request $request) {
    if ($request -> isMethod('POST')) {

    }
    $categories = Category::simplePaginate(2);
    return view('shop/categories', ['categories' => $categories]);
  }

}
