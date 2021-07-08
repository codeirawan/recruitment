<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Http\Request;
use App\Models\Product\PurchasePost;
use App\Http\Controllers\Api\ApiController;
use App\Transformers\Product\PurchaseTransformer;

class PurchaseController extends ApiController
{
    public function show($id)
    {
        $purchase = PurchasePost::with([
                            'supplier' => function($query) { $query->withoutGlobalScopes(); },
                            'paymentMethod' => function($query) { $query->withoutGlobalScopes(); }
                        ])
                        ->whereIn('status', ['Returned', 'Incomplete', 'Completed'])
                        ->findOrFail($id);

        return $this->setIncludedRelation(['supplier', 'payment_method', 'details.product'])
                    ->respondTransform($purchase, new PurchaseTransformer);
    }
}
