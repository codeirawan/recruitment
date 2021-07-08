<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Master\ProductCategory;
use App\Models\Product\ProductSupplier;
use App\Http\Controllers\Api\ApiController;
use App\Transformers\Product\ProductCategoryTransformer;

class ProductCategoryController extends ApiController
{
    public function getCategoryBySupplier($supplierId)
    {
        $productIds = ProductSupplier::select('product_id')->whereSupplierId($supplierId)->pluck('product_id');
        $productCategoryIds = Product::select('category_id')->whereIn('id', $productIds)->groupBy('category_id')->pluck('category_id');
        $productCategories = ProductCategory::select('id', 'code', 'name')->whereIn('id', $productCategoryIds)->orderBy('code')->get();

        return $this->respondTransform($productCategories, new ProductCategoryTransformer);
    }
}
