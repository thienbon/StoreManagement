<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Models\Item;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateItemQuantities
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChanged $event)
    {
        if ($event->order->status == 'done') {
            foreach ($event->order->orderItems as $orderItem) {
                $item = Item::find($orderItem->item_id);
                if ($item) {
                    $item->quantity_in_stock -= $orderItem->quantity;
                    $item->save();
                }
            }
        }
    }
}
