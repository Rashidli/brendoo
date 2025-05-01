<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductService {
    public function filterProducts(Request $request): Builder
    {

        $query = Product::query();

        if ($request->filled('title')) {
            $query->whereHas('translation', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->title . '%');
            });
        }

        if ($request->filled('code')) {
            $query->where('code', 'like', '%' . $request->code . '%');
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('stock')) {
            $query->where('stock', '<', 5);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('subcategory')) {
            $query->where('sub_category_id', $request->subcategory);
        }

        return $query;

    }
}
