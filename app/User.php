<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Exception;

class User extends Authenticatable {

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $rememberTokenName = false;
  protected $fillable = ['name', 'email', 'phone_number', 'username', 'password'];
    protected $allAttributes = ['id', 'name', 'email', 'phone_number', 'username', 'password', 'created_at', 'updated_at', 'deleted_at'];


  public static function addUser($data) {
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

  public static function getUsers($where = null, $groupBy = null, $having = null, $orderBy = null, $paginateRequired = false, $paginateItems = 3) {
    $users = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $users = $users -> where($where);
    }
    if ($groupBy != null) {
      foreach ($groupBy as $eachGroupBy) {
        if (!in_array($eachGroupBy[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $users = $users -> groupBy($groupBy);
    }
    if ($having != null) {
      foreach ($having as $eachHaving) {
        if (!in_array($eachHaving[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $users = $users -> having($having);
    }
    if ($orderBy != null) {
      if (!in_array($orderBy[0], (new self) -> allAttributes)) {
        throw new Exception();
      }
      $users = $users -> orderBy($orderBy[0], $orderBy[1]);
    }
    if ($paginateRequired) {
      return $users -> simplePaginate($paginateItems);
    }
    else {
      return $users -> get();
    }
  }

  public static function getUser($where = null) {
    $user = new self;
    if ($where != null) {
      foreach ($where as $eachWhere) {
        if (!in_array($eachWhere[0], (new self) -> allAttributes)) {
          throw new Exception();
        }
      }
      $user = $user -> where($where);
    }
    if (empty($user)) {
      return null;
    }
    return $user -> first();
  }

  public static function setUser($where, $data) {
    $user = User::where($where) -> first();
    if (!empty($user)) {
      foreach ($data as $attr => $val) {
        if (in_array($attr, (new self) -> fillable)) {
          $user[$attr] = $val;
        }
      }
      return $user -> save();
    }
    return null;
  }

}