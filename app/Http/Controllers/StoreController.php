<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\StoreUpdateRequest;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the search query from the request
        $search = $request->query('search');

        // Fetch stores, applying the search filter if provided
        $stores = Store::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);

        // Pass the stores data and search query to the view
        return view('stores.index', [
            'stores' => $stores,
            'search' => $search,
            'i' => (request()->input('page', 1) - 1) * 10 // Adjust page number for correct row count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {   
        Store::create($request->validated());
           
        return redirect()->route('stores.index')
                         ->with('success', 'store created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store): View
    {
        return view('stores.store-details', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store): View
    {
        return view('stores.edit',compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, Store $store): RedirectResponse
    {
        $store->update($request->validated());
          
        return redirect()->route('stores.index')
                        ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store): RedirectResponse
    {
        $store->delete();
           
        return redirect()->route('stores.index')
                        ->with('success','Product deleted successfully');
    }
    public function tables(Store $store)
    {
        $tables = $store->tables()->paginate(10); // Adjust pagination as needed

        return view('stores.tables', compact('store', 'tables'));
    }
}
