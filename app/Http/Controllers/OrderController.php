<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Table;

use App\Models\Item;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Events\OrderStatusChanged;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = Order::latest()->paginate(5);
        return view('orders.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $items = Item::all();
        return view('orders.create', compact('items'));
    }
    public function createForTable(Table $table)
    {
        $items = Item::all(); // Fetch all items for the order form
        return view('orders.create', compact('table', 'items'));
    }
    public function createGeneral()
    {
        $tables = Table::all(); // Fetch all tables to allow the user to select one
        $items = Item::all(); // Fetch all items for the order form
        return view('orders.create_general', compact('tables', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): RedirectResponse
    {
        $order = Order::create($request->validated());

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }

        if ($request->redirect_to == 'tables.orders') {
            return redirect()->route('tables.orders', ['table' => $request->table_id])
                ->with('success', 'Order created successfully.');
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        $order->load('orderItems.item');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        $items = Item::all();
        return view('orders.edit', compact('order', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        // Update order items
        $order->orderItems()->delete();
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }
        if ($order->status == 'done') {
            event(new OrderStatusChanged($order));
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully');
    }
    public function checkout(Order $order)
    {
        // Calculate total bill, handle case where there are no items
        $totalBill = $order->items ? $order->items->sum(function ($item) {
            return $item->price * $item->pivot->quantity;
        }) : 0;

        return view('orders.checkout', compact('order', 'totalBill'));
    }

    public function completeCheckout(Request $request, Order $order)
    {
        // Update order status to 'checkout'
        $order->status = 'checkout';
        $order->save();

        return redirect()->route('feedback.create')->with('success', 'Order has been checked out successfully!');
    }
    public function showTableOrdersCheckout(Table $table)
    {
        // Fetch orders that are not already checked out
        $orders = $table->orders()->where('status', '!=', 'checkout')->get();

        // Calculate the total bill for all orders of the table
        $totalBill = $orders->sum(function ($order) {
            return $order->items->sum(function ($item) {
                return $item->pivot->quantity * $item->pivot->price;
            });
        });

        return view('tables.orders_checkout', compact('table', 'orders', 'totalBill'));
    }

    public function checkoutTableOrders(Table $table, Request $request)
    {
        $orders = $table->orders()->where('status', '!=', 'checkout')->get();

        $request->validate([
            'paymentMethod' => 'required|in:cash,credit_card,paypal',
        ]);

        $paymentMethod = $request->input('paymentMethod');

        foreach ($orders as $order) {
            $order->status = 'checkout';
            $order->save();
        }

        return redirect()->route('tables.show', $table->id)
            ->with('success', 'All orders for table ' . $table->id . ' have been checked out successfully.');
    }

    public function orderMore(Order $order)
{
    $items = Item::all();
    return view('orders.order_more', compact('order', 'items'));
}

public function addItems(Request $request, Order $order)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.id' => 'required|exists:items,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    foreach ($request->items as $item) {
        $orderItem = $order->orderItems()->where('item_id', $item['id'])->first();
        if ($orderItem) {
            $orderItem->quantity += $item['quantity'];
            $orderItem->save();
        } else {
            $order->orderItems()->create([
                'item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }
    }

    return redirect()->route('tables.orders', $order->table_id)->with('success', 'Items added to order successfully.');
}
}
