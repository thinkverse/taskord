<?php

namespace App\Notifications\Product;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MemberRemoved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $userId;

    public function __construct($product, $userId)
    {
        $this->product = $product;
        $this->userId = $userId;
    }

    public function via()
    {
        return ['database'];
    }

    public function toDatabase()
    {
        return [
            'product_id' => $this->product->id,
            'user_id'    => $this->userId,
        ];
    }
}
