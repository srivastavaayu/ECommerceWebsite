<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class Category extends Model {

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'description'];
  protected $allAttributes = ['id', 'name', 'description', 'created_at', 'updated_at', 'deleted_at'];


  public static function addCategory($data) {
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

  public static function getCategories($where = null, $groupBy = null, $having = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $categories = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $categories = $categories -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $categories = $categories -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $categories = $categories -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        return null;
      }
      $categories = $categories -> orderBy($orderBy[0], $orderBy[1]);
    }
    if ($paginateRequired) {
      return $categories -> simplePaginate($paginateItems);
    }
    else {
      return $categories -> get();
    }
  }

  public static function getCategory($where = null) {
    $category = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          return null;
        }
      }
      $category = $category -> where($where);
    }
    if (empty($category)) {
      return null;
    }
    return $category -> first();
  }

}
