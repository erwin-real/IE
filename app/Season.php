<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    // Table Name
    protected $table = 'seasons';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function forecast() { return $this->belongsTo('App\Forecast'); }
}
