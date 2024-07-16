<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;

class CustomerOrderController extends Controller
{
    public function create()
    {
        $items = Item::all();
        return view('customer.orders.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
        ]);

        $order = Order::create([
            'table_id' => $request->table_id,
            'status' => 'pending',
        ]);

        $order->items()->attach($request->item_ids);

        return redirect()->route('customer.orders.create')->with('success', 'Order placed successfully!');
    }
}
