<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'description'];

  public static function addCategory($data) {
    Category::create($data);
  }

  public static function getCategories($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $categories = new Category;
    if ($where != null) {
      $categories = $categories -> where($where);
    }
    if ($groupBy != null) {
      $categories = $categories -> groupBy($groupBy);
    }
    if ($having != null) {
      $categories = $categories -> having($having);
    }
    if ($orderBy != null) {
      $categories = $categories -> orderBy($orderBy[0], $orderBy[1]);
    }
    $categories = $categories;
    return $categories;
  }

  public static function getCategory($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $category = new Category;
    if ($where != null) {
      $category = $category -> where($where);
    }
    if ($groupBy != null) {
      $category = $category -> groupBy($groupBy);
    }
    if ($having != null) {
      $category = $category -> having($having);
    }
    if ($orderBy != null) {
      $category = $category -> orderBy($orderBy[0], $orderBy[1]);
    }
    $category = $category -> firstOr(function() {
      return null;
    });
    return $category;
  }

}
