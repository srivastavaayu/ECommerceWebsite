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

  public static function getProducts($where = null, $groupBy = null, $having = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $products = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    if ($paginateRequired) {
      return $products -> simplePaginate($paginateItems);
    }
    else {
      return $products -> get();
    }
  }

  public static function getProductsWithCustomPagination($where = null, $groupBy = null, $having = null, $orderBy = null, $skip = 0, $take = 3) {
    $products = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $products -> skip($skip) -> take($take) -> get();
  }

  public static function getProductsCount($where = null, $groupBy = null, $having = null)
  {
    $products = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $products = $products -> having($having);
    }
    return $products -> count();

  }

  public static function getProduct($where = null)
  {
    $product = new self;
    if (empty($product)) {
      throw new Exception();
    }
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $product = $product -> where($where);
    }
    if (empty($product)) {
      return null;
    }
    return $product -> first();
  }

  public static function setProduct($where, $data) {
    $product = Product::where($where) -> first();
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
