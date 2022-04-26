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
      throw new Exception("Category cannot be created!");
    }
    foreach ($data as $attr => $val) {
      if (!in_array($attr, (new self) -> fillable)) {
        throw new Exception("Category cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function getCategories($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $categories = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $categories = $categories -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $categories = $categories -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $categories = $categories -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        throw new Exception();
      }
      $categories = $categories -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $categories;
  }

  public static function getCategory($where = null) {
    $category = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $category = $category -> where($where);
    }
    $category = $category -> first();
    return $category;
  }

}
