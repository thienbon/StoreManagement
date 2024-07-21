<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Http\Requests\TableUpdateRequest;
use App\Http\Requests\TableStoreRequest;
use App\Models\Store;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\Order;




class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::with('store')->latest()->paginate(5);
        return view('tables.index', compact('tables'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Store $store): View
    {
        return view('tables.create', compact('store'));
    }
    public function createGeneral(): View
    {
        $stores = Store::all(); // Fetch all stores to allow the user to select one
        return view('tables.create_general', compact('stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'location' => 'required',
            'capacity' => 'required|integer',
        ]);

        Table::create([
            'store_id' => $request->store_id,
            'location' => $request->location,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('tables.index')
            ->with('success', 'Table created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        return view('tables.show', compact('table'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(TableUpdateRequest $request, Store $store, Table $table): RedirectResponse
    {
        $table->update($request->validated());

        return redirect()->route('tables.index', $store)
            ->with('success', 'Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Product deleted successfully');
    }

    /**
     * Update status order.
     */
    public function updateStatus(Table $table): RedirectResponse
    {
        if ($table->status == 'available') {
            $table->status = 'ordered';
            $table->save();

            return redirect()->route('tables.index')->with('success', 'Table status updated to ordered.');
        }

        return redirect()->route('tables.index')->with('error', 'Table status could not be updated.');
    }
    /**
     * Update status to available.
     */
    public function unorder(Table $table): RedirectResponse
    {
        if ($table->status == 'ordered') {
            $table->status = 'available';
            $table->save();

            return redirect()->route('tables.index')->with('success', 'Table status updated to available.');
        }

        return redirect()->route('tables.index')->with('error', 'Table status could not be updated.');
    }

    public function orders(Table $table)
    {
        $orders = Order::where('table_id', $table->id)
            ->where('status', '!=', 'checkout')
            ->paginate(10);
        return view('tables.orders', compact('orders', 'table'));
    }
    public function checkout(Table $table)
    {
        // Get all orders for this table
        $orders = Order::where('table_id', $table->id)->where('status', '!=', 'checkout')->get();
        $total = $orders->sum(function ($order) {
            return $order->items->sum(function ($item) {
                return $item->pivot->quantity * $item->price;
            });
        });

        return view('tables.checkout', compact('table', 'orders', 'total'));
    }

    public function processCheckout(Request $request, Table $table): RedirectResponse
{
    // Validate the payment method
    $request->validate([
        'payment_method' => 'required|string|in:cash,credit_card,paypal',
    ]);

    // Update the status of all orders for this table to 'checkout'
    Order::where('table_id', $table->id)->where('status', '!=', 'checkout')->update(['status' => 'checkout']);

    // Update the table status to 'available'
    if ($table->status == 'ordered') {
        $table->status = 'available';
        $table->save();
    }

    // Process the payment based on the selected method
    // Here you can add the actual payment processing logic

    return redirect()->route('feedback.create')->with('success', 'All orders have been checked out successfully, and the table status has been updated to available.');
}

}
