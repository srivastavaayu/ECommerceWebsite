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

  public static function getUserByID($id = null) {
    $user = new self;
    if ($id != null) {
      $user = $user -> where('id', $id);
    }
    if (empty($user)) {
      return null;
    }
    return $user -> first();
  }

  public static function getUserByUsername($username = null) {
    $user = new self;
    if ($username != null) {
      $user = $user -> where('username', $username);
    }
    if (empty($user)) {
      return null;
    }
    return $user -> first();
  }

  public static function getUserByName($name = null) {
    $user = new self;
    if ($name != null) {
      $user = $user -> where('name', $name);
    }
    if (empty($user)) {
      return null;
    }
    return $user -> first();
  }

  public static function setUser($id, $data) {
    $user = User::where('id', $id) -> first();
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