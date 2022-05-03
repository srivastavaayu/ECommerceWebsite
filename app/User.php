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


  /**
   * It takes an array of data, checks if the data is empty, checks if the data is fillable, and then
   * creates the data
   *
   * @param data The data to be added to the database.
   *
   * @return A new user is being created.
   */
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

  /**
   * It returns the user with the given id.
   *
   * @param id The id of the user you want to get.
   *
   * @return The first user in the database.
   */
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

  /**
   * > This function returns a user object if the username is found in the database
   *
   * @param username The username of the user you want to get.
   *
   * @return The first user with the username that is passed in.
   */
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

  /**
   * > This function returns a user object based on the name of the user
   *
   * @param name The name of the user you want to get.
   *
   * @return The first user with the name .
   */
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

  /**
   * > It takes an id and an array of data, finds the user with that id, and updates the user with the
   * data
   *
   * @param id The id of the user you want to update.
   * @param data an array of attributes and values to be updated
   *
   * @return The user object is being returned.
   */
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