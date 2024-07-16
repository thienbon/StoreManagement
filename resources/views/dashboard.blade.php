<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a class="btn btn-primary w-100" href="{{ route('stores.index') }}">Stores</a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <a class="btn btn-secondary w-100" href="{{ route('tables.index') }}">Tables</a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <a class="btn btn-success w-100" href="{{ route('orders.index') }}">Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
