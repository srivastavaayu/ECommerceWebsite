<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EComWebStat extends Model
{

  protected $fillable = ['product_id, units_sold'];

  public static function addEComWebStat($data) {
    self::create($data);
  }

}
