<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Notifications\BulkNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBulkNotificationJob implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public $title;
    public $body;

    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function handle()
    {
        Customer::query()->chunk(1000, function ($customers) {
            foreach ($customers as $customer) {
                $customer->notify(new BulkNotification($this->title, $this->body));
            }
        });
    }
}
