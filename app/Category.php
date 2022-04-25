<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['name', 'description'];

  public static function addCategory($data)
  {
    if (empty($data)) {
      throw new Exception("Category cannot be created!");
    }
    foreach ($data as $attr => $val)
    {
      if (!in_array($attr, (new self) -> fillable))
      {
        throw new Exception("Category cannot be created!");
      }
    }
    return self::create($data);
  }

  public static function getCategories($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $categories = new self;
    if ($where != null)
    {
      $categories = $categories -> where($where);
    }
    if ($groupBy != null)
    {
      $categories = $categories -> groupBy($groupBy);
    }
    if ($having != null)
    {
      $categories = $categories -> having($having);
    }
    if ($orderBy != null)
    {
      $categories = $categories -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $categories;
  }

  public static function getCategory($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $category = new self;
    if ($where != null)
    {
      $category = $category -> where($where);
    }
    if ($groupBy != null)
    {
      $category = $category -> groupBy($groupBy);
    }
    if ($having != null)
    {
      $category = $category -> having($having);
    }
    if ($orderBy != null)
    {
      $category = $category -> orderBy($orderBy[0], $orderBy[1]);
    }
    $category = $category -> first();
    return $category;
  }

}
