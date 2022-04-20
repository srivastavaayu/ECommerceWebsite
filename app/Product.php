<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['category_id', 'sku', 'name', 'description', 'user_id', 'image_path', 'price', 'unit', 'quantity', 'is_archived', 'rating'];

  public static function addProduct($data)
  {
    Product::create($data);
  }

  public static function getProducts($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $products = new Product;
    if ($where != null)
    {
      $products = $products -> where($where);
    }
    if ($groupBy != null)
    {
      $products = $products -> groupBy($groupBy);
    }
    if ($having != null)
    {
      $products = $products -> having($having);
    }
    if ($orderBy != null)
    {
      $products = $products -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $products;
  }

  public static function getProduct($where = null)
  {
    $product = new Product;
    if ($where != null)
    {
      $product = $product -> where($where);
    }
    $product = $product -> first();
    return $product;
  }

  public static function setProduct($where, $data)
  {
    $product = Product::where($where) -> first();
    if (!empty($product))
    {
      foreach ($data as $attr => $val)
      {
        // if (in_array($attr, $this -> fillable))
        // {
        //   $product[$attr] = $val;
        // }
        $product[$attr] = $val;
      }
      $product -> save();
    }
  }

}
