<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'is_archived'];

  public static function addProduct($data) {
    Product::create($data);
  }

  public static function getProducts($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $products = new Product;
    if ($where != null) {
      $products = $products -> where($where);
    }
    if ($groupBy != null) {
      $products = $products -> groupBy($groupBy);
    }
    if ($having != null) {
      $products = $products -> having($having);
    }
    if ($orderBy != null) {
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    $products = $products;
    return $products;
  }

  public static function getProduct($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $product = new Product;
    if ($where != null) {
      $product = $product -> where($where);
    }
    if ($groupBy != null) {
      $product = $product -> groupBy($groupBy);
    }
    if ($having != null) {
      $product = $product -> having($having);
    }
    if ($orderBy != null) {
      $product = $product -> orderBy($orderBy[0], $orderBy[1]);
    }
    $product = $product -> firstOr(function() {
      return null;
    });
    return $product;
  }

  public static function setProduct($where, $data) {
    $product = Product::where($where) -> firstOr(function() {
      return null;
    });
    foreach ($data as $dataPoint) {
      $product[$dataPoint[0]] = $dataPoint[1];
    }
    $product -> save();
  }

}
