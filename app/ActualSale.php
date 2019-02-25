<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActualSale extends Model
{
    // Table Name
    protected $table = 'actual_sales';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function forecast() { return $this->belongsTo('App\Forecast'); }
}
