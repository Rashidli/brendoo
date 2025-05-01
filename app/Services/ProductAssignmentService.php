<?php

namespace App\Services;
use Illuminate\Database\Eloquent\Model;

class ProductAssignmentService{
    /**
     * Assign a product to an entity (Instagram, TikTok, Campaign, etc.).
     *
     * @param Model $entity
     * @param int $productId
     * @return array
     */
    public function assignProduct(Model $entity, int $productId): array
    {
        if (!$entity->products()->where('product_id', $productId)->exists()) {
            $entity->products()->attach($productId);
            return ['status' => 'success', 'message' => 'Product assigned successfully.'];
        }

        return ['status' => 'error', 'message' => 'Product is already assigned.'];
    }

    /**
     * Remove a product from an entity (Instagram, TikTok, Campaign, etc.).
     *
     * @param Model $entity
     * @param int $productId
     * @return array
     */
    public function removeProduct(Model $entity, int $productId): array
    {
        if ($entity->products()->where('product_id', $productId)->exists()) {
            $entity->products()->detach($productId);
            return ['status' => 'success', 'message' => 'Product unassigned successfully.'];
        }

        return ['status' => 'error', 'message' => 'Product is not assigned to this entity.'];
    }
}
