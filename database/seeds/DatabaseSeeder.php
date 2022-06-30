<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerSeeder::class);
        $this->call(ProductCategorySeeder::class);
        Brand::create(['name'=>'Sem-marca']);
        $this->call(BrFoodBrandSeeder::class);
    }
}