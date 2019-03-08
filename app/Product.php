<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{    
    use Sortable;

    protected $fillable = [
        'name', 'desc',
        'price', 'srp', 'source', 
        'contact', 'stocks'
    ];

    public $sortable = [
        'name', 'desc',
        'price', 'srp', 'source',
        'contact', 'stocks', 'created_at', 'updated_at',
    ];
    
    // Table Name
    protected $table = 'products';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;
    
}
