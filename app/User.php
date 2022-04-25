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

  public static function addUser($data)
  {
    foreach ($data as $attr => $val)
    {
      if (!in_array($attr, (new self) -> fillable))
      {
        throw new Exception("User cannot be created!");
      }
    }
    User::create($data);
  }

  public static function getUsers($where = null, $groupBy = null, $having = null, $orderBy = null)
  {
    $users = new User;
    if ($where != null)
    {
      $users = $users -> where($where);
    }
    if ($groupBy != null)
    {
      $users = $users -> groupBy($groupBy);
    }
    if ($having != null)
    {
      $users = $users -> having($having);
    }
    if ($orderBy != null)
    {
      $users = $users -> orderBy($orderBy[0], $orderBy[1]);
    }
    return $users;
  }

  public static function getUser($where = null)
  {
    $user = new User;
    if ($where != null)
    {
      $user = $user -> where($where);
    }
    $user = $user -> first();
    return $user;
  }

  public static function setUser($where, $data)
  {
    $user = User::where($where) -> first();
    if (!empty($user))
    {
      foreach ($data as $attr => $val)
      {
        if (in_array($attr, (new self) -> fillable))
        {
          $user[$attr] = $val;
        }
      }
      $user -> save();
    }
  }

}