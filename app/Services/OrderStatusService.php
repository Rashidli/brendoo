<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\OrderItemStatus;

class OrderStatusService
{
    public function updateStatus($orderItemId, $newStatus, $newAdminStatus = null)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);
        $order = $orderItem->order;

        $oldStatus = $orderItem->status;
        $orderItem->status = $newStatus;

        if ($newAdminStatus){
            $orderItem->admin_status = $newAdminStatus;
        }

        $orderItem->save();

        OrderItemStatus::create([
            'order_item_id' => $orderItem->id,
            'status' => $newStatus,
        ]);

        $this->adjustFinalPrice($order, $orderItem, $oldStatus, $newStatus);

        // Buraya mail və ya notification göndərmə funksionallıqları əlavə oluna bilər

        return $order;
    }

    protected function adjustFinalPrice($order, $item, $oldStatus, $newStatus)
    {
        $affected = ['cancelled', 'out_of_stock'];
        $amount = $item->price * $item->quantity;

        if (!in_array($oldStatus, $affected) && in_array($newStatus, $affected)) {
            $order->final_price -= $amount;
        } elseif (in_array($oldStatus, $affected) && !in_array($newStatus, $affected)) {
            $order->final_price += $amount;
        }

        $order->save();
    }
}
