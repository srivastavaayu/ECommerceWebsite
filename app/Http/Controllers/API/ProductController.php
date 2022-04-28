<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Product;
use App\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

  public function getProducts(Request $request) {
    if ($request -> has('userName')) {
      $user = User::getUser([['name', $request -> userName]]);
      if (!empty($user)) {
        $products = Product::getProducts([['user_id', $user -> id]]);
        return response() -> json($products, 200);
      }
      else {
        return response() -> json(["message" => "No products exist by this user."], 404);
      }
    }
    if ($request -> has('orderID')) {
      $items = OrderDetail::getOrderDetails([['order_id', $request -> orderID]]);
      if (!empty($items) and count($items) > 0) {
        $products = [];
        foreach ($items as $item) {
          array_push($products, Product::getProduct([['id', $item -> item_id]]));
        }
        return response() -> json($products, 200);
      }
      else {
        return response() -> json(["message" => "No products exist by this order ID."], 404);
      }
    }
    if ($request -> has('productID')) {
      $product = Product::getProduct([['id', $request -> productID]]);
      if (!empty($product)) {
        return response() -> json($product, 200);
      }
      else {
        return response() -> json(["message" => "No product exists with this ID."], 404);
      }
    }
    $products = Product::getProducts();
    return response() -> json($products, 200);
  }

  public function getProductsWithPagination(Request $request) {
    $currentPage = 1;
    if ($request -> has('page')) {
      $currentPage = (int)$request -> page;
    }
    if ($currentPage < 1)
      return response() -> json(['error' => 'Invalid Page Requested'], 422);
    $products = Product::getProductsCount();
    $totalPages = ceil($products / ($request -> items));
    if ($currentPage <= $totalPages) {
      $products = Product::getProductsWithCustomPagination(null, null, null, null, (($currentPage - 1) * $request -> items), ($request -> items));
      return response() -> json(['currentPage' => $currentPage, 'totalPages' => $totalPages, 'data' => $products], 200);
    }
    else {
      return response() -> json(['error' => 'Invalid Page Requested'], 422);
    }
  }

}
