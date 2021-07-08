<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product\Product')->using('App\Models\Product\ProductSupplier');
    }
}
