<?php

namespace App\Models\Product;

use App\Models\Product\Supplier;
use App\Models\Master\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\PurchasePostDetail;

class PurchasePost extends Model
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function details()
    {
        return $this->hasMany(PurchasePostDetail::class);
    }
}
