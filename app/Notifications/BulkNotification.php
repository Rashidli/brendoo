<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Illuminate\Queue\SerializesModels;

class BulkNotification extends Notification
{
    use Queueable, SerializesModels;

    protected $title;
    protected $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function via($notifiable)
    {
        return ['database', 'firebase']; // or use Firebase if needed
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

//    public function toFirebase($notifiable)
//    {
//        $message = CloudMessage::withTarget('token', $notifiable->device_token)
//            ->withNotification(FirebaseNotification::create(
//                'Order Status Updated',
//                "Your order status has been updated to {$this->order->status}."
//            ));
//
//        return $message;
//    }
}
