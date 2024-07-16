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


class OrdersController extends Controller
{
    public function index(Store $store, Table $table): View
    {
        $orders = $table->orders()->with('orderItems')->latest()->paginate(10);
        return view('orders.index', compact('store', 'table', 'orders'));
    }

    // Display the details of a specific order
    public function show(Store $store, Table $table, Order $order): View
    {
        return view('orders.show', compact('store', 'table', 'order'));
    }
}
