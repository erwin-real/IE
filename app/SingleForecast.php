<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleForecast extends Model
{
    // Table Name
    protected $table = 'single_forecasts';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function forecast() { return $this->belongsTo('App\Forecast'); }
}
