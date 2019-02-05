<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loss extends Model
{
    protected $fillable = [
        'product_id', 'quantity', 
        'reason', 'loss_money'
    ];

    // Table Name
    protected $table = 'losses';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;
    
    public function product() { return $this->belongsTo('App\Product'); }
}
