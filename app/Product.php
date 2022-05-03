<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Product extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'units_sold', 'is_archived', 'rating'];
  protected $allAttributes = ['id', 'category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'units_sold', 'is_archived', 'rating', 'created_at', 'updated_at', 'deleted_at'];

  public static function addProduct($data) {
    if (empty($data)) {
      return null;
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        return null;
      }
    }
    return self::create($data);
  }

  public static function getProducts($userId = null, $categoryId = null, $isArchived = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $products = new self;
    if ($userId != null) {
      $products = $products -> where('user_id', $userId);
    }
    if ($categoryId != null) {
      $products = $products -> where('category_id', $categoryId);
    }
    if ($isArchived != null) {
      $products = $products -> where('is_archived', $isArchived);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    if (empty($products)) {
      return null;
    }
    if ($paginateRequired) {
      return $products -> simplePaginate($paginateItems);
    }
    else {
      return $products -> get();
    }
  }

  public static function getProductsWithSearch($searchTerm = null, $isArchived = null, $orderBy = null) {
    $products = new self;
    if ($searchTerm != null) {
      $products = $products -> where('name', 'LIKE', '%'.$searchTerm.'%') -> orWhere('description', 'LIKE', '%'.$searchTerm.'%');
    }
    if ($isArchived != null) {
      $products = $products -> where('is_archived', $isArchived);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    if (empty($products)) {
      return null;
    }
    return $products -> get();
  }

  public static function getProductsWithCustomPagination($skip = 0, $take = 3) {
    $products = new self;
    return $products -> skip($skip) -> take($take) -> get();
  }

  public static function getProductsCount()
  {
    $products = new self;
    return $products -> count();

  }

  public static function getProduct($id = null)
  {
    $product = new self;
    if ($id != null) {
      $product = $product -> where('id', $id);
    }
    if (empty($product)) {
      return null;
    }
    return $product -> first();
  }

  public static function setProduct($id, $data) {
    $product = Product::where('id', $id) -> first();
    if (!empty($product)) {
      foreach ($data as $attr => $val) {
        if (in_array($attr, (new self) -> fillable)) {
          $product[$attr] = $val;
        }
      }
      return $product -> save();
    }
  }

}
