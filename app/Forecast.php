<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    // Table Name
    protected $table = 'forecasts';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function singleForecasts() { return $this->hasMany('App\SingleForecast'); }

    public function actualSales() { return $this->hasMany('App\ActualSaleForecast'); }
}
