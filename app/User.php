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

}
