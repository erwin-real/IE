<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleTransaction extends Model
{
    // Table Name
    protected $table = 'single_transactions';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    public function transaction() { return $this->belongsTo('App\Transaction'); }
    public function product() { return $this->belongsTo('App\Product'); }
}
