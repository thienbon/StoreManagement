<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $items = Item::all();
        return view('products.create', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'name' => 'required|string|exists:items,name',
            'quantity' => 'required|integer|min:1',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
}
