<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\Option;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StockNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    use Queueable, SerializesModels;

    public Customer $customer;
    public Product $product;
    public Option $option;

    public function __construct(Customer $customer, Product $product, Option $option)
    {
        $this->customer = $customer;
        $this->product = $product;
        $this->option = $option;
    }

    public function build(): self
    {
        return $this
            ->subject('Stok Bildirişi - ' . $this->product->title)
            ->view('emails.stock_notification');
    }
}
