<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Exception;

class EComWebStat extends Model {

  protected $fillable = ['id', 'product_id, units_sold'];

  public static function addEComWebStat($data) {
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

}
