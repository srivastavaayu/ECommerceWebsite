<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'units_sold', 'is_archived', 'rating'];

  public static function addProduct($data) {
    if (empty($data)) {
      throw new Exception("Product cannot be created!");
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        throw new Exception("Product cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function getProducts($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $products = new self;
    if ($where != null) {
      foreach ($where as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $products = $products -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $products = $products -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $products = $products -> having($having);
    }
    if ($orderBy != null) {
      foreach ($orderBy as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $products;
  }

  public static function getProduct($where = null)
  {
    $product = new self;
    if ($where != null) {
      foreach ($where as $attr => $val) {
        if (!in_array($attr, (new self) -> fillable)) {
          throw new Exception();
        }
      }
      $product = $product -> where($where);
    }
    $product = $product -> first();
    return $product;
  }

  public static function setProduct($where, $data) {
    $product = Product::where($where) -> first();
    if (!empty($product)) {
      foreach ($data as $attr => $val) {
        if (in_array($attr, (new self) -> fillable)) {
          $user[$attr] = $val;
        }
      }
      return $product -> save();
    }
  }

}
