<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = Product::query()->with('filters.options');
    }

    public function filterTitle(?string $title): self
    {
        if ($title) {
            $this->query->whereHas(
                'translation',
                fn ($q) => $q->where('title', 'like', "%{$title}%")
            );
        }

        return $this;
    }

    public function filterCode(?string $code): self
    {
        if ($code) {
            $this->query->where('code', 'like', "%{$code}%");
        }

        return $this;
    }

    public function filterIsActive(?bool $isActive): self
    {
        if (null !== $isActive) {
            $this->query->where('is_active', $isActive);
        }

        return $this;
    }

    public function filterLowStock(?bool $enabled): self
    {
        if ($enabled) {
            $this->query->where('stock', '<', 5);
        }

        return $this;
    }

    public function filterCategory(?int $categoryId): self
    {
        if ($categoryId) {
            $this->query->where('category_id', $categoryId);
        }

        return $this;
    }

    public function filterSubcategory(?int $subcategoryId): self
    {
        if ($subcategoryId) {
            $this->query->where('sub_category_id', $subcategoryId);
        }

        return $this;
    }

    public function filterBrand(?int $brandId): self
    {
        if ($brandId) {
            $this->query->where('brand_id', $brandId);
        }

        return $this;
    }

    public function filterUser(?int $userId): self
    {
        if ($userId) {
            $this->query->where('user_id', $userId);
        }

        return $this;
    }

    public function filterStartDate(?string $startDate): self
    {
        if ($startDate) {
            $this->query->where('activation_date', '>=', $startDate . ' 00:00:00');
        }

        return $this;
    }

    public function filterEndDate(?string $endDate): self
    {
        if ($endDate) {
            $this->query->where('activation_date', '<=', $endDate . ' 23:59:59');
        }

        return $this;
    }


    public function getQuery(): Builder
    {
        return $this->query;
    }
}
