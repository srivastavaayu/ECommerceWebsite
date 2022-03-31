<?php

namespace App\Http\Controllers\Inventory;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{

  public $sortBehavior = "ASC";
  public function handle(Request $request) {
    $info = "";
    if ($request -> has('sort')) {
      $this -> sortBehavior = $request -> sort;
    }
    if ($request -> isMethod('POST')) {
      $product = Product::find($request -> productId);
      if ($product -> is_archived) {
        $product -> is_archived = 0;
        $info = "Product unarchived successfully!";
      }
      else {
        $product -> is_archived = 1;
        $info = "Product archived successfully!";
      }
      $product -> save();
    }
    $allProducts = Product::where('user_id', Auth::id()) -> orderBy('updated_at', $this -> sortBehavior) -> get();
    $activeProducts = Product::where([['user_id', Auth::id()], ['is_archived', 0]]) -> orderBy('updated_at', $this -> sortBehavior) -> get();
    $archivedProducts = Product::where([['user_id', Auth::id()], ['is_archived', 1]]) -> orderBy('updated_at', $this -> sortBehavior) -> get();
    $categories = Category::all();
    return view('inventory/products', ['allProducts' => $allProducts, 'activeProducts' => $activeProducts, 'archivedProducts' => $archivedProducts, 'categories' => $categories, 'sortBehavior' => $this -> sortBehavior, 'info' => $info]);
  }

}
