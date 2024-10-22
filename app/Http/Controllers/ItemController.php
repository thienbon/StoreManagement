<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Response;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::latest()->paginate(5);

        return view('items.index', compact('items'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required',
        'description' => 'required',
        'quantity_in_stock' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $input = $request->all();

    if ($image = $request->file('image')) {
        $destinationPath = 'images/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $input['image'] = "$destinationPath$profileImage";
    }

    Item::create($input);

    return redirect()->route('items.index')
                    ->with('success', 'Item created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.item-details', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required',
        'description' => 'required',
        'quantity_in_stock' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $input = $request->all();

    if ($image = $request->file('image')) {
        $destinationPath = 'images/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $input['image'] = "$destinationPath$profileImage";
    } else {
        unset($input['image']);
    }

    $item->update($input);

    return redirect()->route('items.index')
                    ->with('success', 'Item updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Item deleted successfully');
    }
    public function showImportQuantityForm(): View
    {
        return view('items.import');
    }

    public function importQuantityFromProducts(Request $request)
    {
        try {
            // Get all products with their corresponding items
            $products = Product::with('item')->get();

            // Loop through each product and update its corresponding item's quantity
            foreach ($products as $product) {
                if ($product->item) {
                    $item = $product->item;
                    $item->quantity_in_stock += $product->quantity; // Assuming 'quantity' field in both Product and Item
                    $item->save();
                }
            }

            return response()->json(['success' => true, 'message' => 'Quantity imported successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to import quantity.']);
        }
    }
}
