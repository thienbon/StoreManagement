<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;

class GenerateInventoryReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:inventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a daily CSV report of items remaining in inventory';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $items = Item::all(['name', 'price', 'description', 'quantity_in_stock']);
        $csv = Writer::createFromString('');
        $csv->insertOne(['Name', 'Price', 'Description', 'Quantity in Stock']);

        foreach ($items as $item) {
            $csv->insertOne([$item->name, $item->price, $item->description, $item->quantity_in_stock]);
        }

        $filename = 'inventory_report_' . now()->format('Y_m_d') . '.csv';
        Storage::disk('local')->put($filename, $csv->toString());

        $this->info('Inventory report generated: ' . $filename);
    }
}
