<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EComWebStat extends Model
{

  protected $fillable = ['product_id, units_sold'];

  public static function addEComWebStat($data) {
    foreach ($data as $attr => $val)
    {
      if (!in_array($attr, (new self) -> fillable))
      {
        throw new Exception("Stat cannot be created!");
      }
    }
    EComWebStat::create($data);
  }

}
