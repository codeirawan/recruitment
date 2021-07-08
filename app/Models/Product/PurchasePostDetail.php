<?php

namespace App\Models\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;

class PurchasePostDetail extends Model
{
    protected $casts = [
        'warranty_expiration_date' => 'date',
        'quantity' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
