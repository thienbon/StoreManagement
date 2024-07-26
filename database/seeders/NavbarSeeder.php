<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\Navbar;
  
class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'name' => 'Stores',
                'route' => 'stores.index',
                'ordering' => 1,
            ],
            [
                'name' => 'Tables',
                'route' => 'tables.index',
                'ordering' => 2,
            ],
            [
                'name' => 'Orders',
                'route' => 'orders.index',
                'ordering' => 3,
            ],
            [
                'name' => 'Feedbacks',
                'route' => 'feedback.index',
                'ordering' => 4,
            ],
        ];
  
        foreach ($links as $key => $navbar) {
            Navbar::create($navbar);
        }
    }
}