<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $rememberTokenName = false;
  protected $fillable = ['name', 'email', 'phone_number', 'username', 'password'];

  public static function addUser($data) {
    User::create($data);
  }

  public static function getUsers($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $users = new User;
    if ($where != null) {
      $users = $users -> where($where);
    }
    if ($groupBy != null) {
      $users = $users -> groupBy($groupBy);
    }
    if ($having != null) {
      $users = $users -> having($having);
    }
    if ($orderBy != null) {
      $users = $users -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $users;
  }

  public static function getUser($where = null, $groupBy = null, $having = null, $orderBy = null) {
    $user = new User;
    if ($where != null) {
      $user = $user -> where($where);
    }
    if ($groupBy != null) {
      $user = $user -> groupBy($groupBy);
    }
    if ($having != null) {
      $user = $user -> having($having);
    }
    if ($orderBy != null) {
      $user = $user -> orderBy($orderBy[0], $orderBy[1]);
    }
    $user = $user -> firstOr(function() {
      return null;
    });
    return $user;
  }

  public static function setUser($where, $data) {
    $user = User::where($where) -> firstOr(function() {
      return null;
    });
    foreach ($data as $dataPoint) {
      $user[$dataPoint[0]] = $dataPoint[1];
    }
    $user -> save();
  }

}
