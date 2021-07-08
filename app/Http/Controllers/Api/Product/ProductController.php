<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Http\Controllers\Api\ApiController;
use App\Transformers\Product\ProductTransformer;

class ProductController extends ApiController
{
    public function getProductByCategory($categoryId)
    {
        $products = Product::select('id', 'code', 'name', 'photo')->whereCategoryId($categoryId)->orderBy('code')->get();

        return $this->respondTransform($products, new ProductTransformer);
    }
}
