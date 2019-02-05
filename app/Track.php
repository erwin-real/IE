<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    // Table Name
    protected $table = 'tracks';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = false;

    public function product() { return $this->belongsTo('App\Product'); }
}
