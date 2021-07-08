<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class PurchasePostStatus extends Model
{
    public $timestamps = false;
    protected $table = 'purchase_post_status';

    protected $casts = [
        'at' => 'datetime',
    ];
}
