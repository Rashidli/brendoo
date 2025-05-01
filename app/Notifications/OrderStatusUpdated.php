<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'firebase']; // Firebase və database ilə göndər
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status'   => $this->order->status,
            'message'  => "Your order status has been updated to {$this->order->status}."
        ];
    }



    public function toFirebase($notifiable)
    {
        $message = CloudMessage::withTarget('token', $notifiable->device_token)
            ->withNotification(FirebaseNotification::create(
                'Order Status Updated',
                "Your order status has been updated to {$this->order->status}."
            ));

        return $message;
    }
}
