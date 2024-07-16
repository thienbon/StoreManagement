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
    public function index(): View
    {
        $stores = Store::latest()->paginate(5);
          
        return view('stores.index', compact('stores'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
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
        return view('stores.show',compact('store'));
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
