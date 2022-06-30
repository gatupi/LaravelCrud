<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Database\PopulateHelper;

class BrFoodBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $brands = PopulateHelper::getBrFoodBrands();
        foreach($brands as $b) {
            Brand::create(['name'=>$b]);
        }
    }
}
