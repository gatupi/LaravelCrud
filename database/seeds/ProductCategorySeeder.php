<?php

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ProductCategory::create(['name'=>'Roupas', 'parent_category'=>null]);
        ProductCategory::create(['name'=>'Camisetas', 'parent_category'=>ProductCategory::select('id')->where('name', 'Roupas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Calças', 'parent_category'=>ProductCategory::select('id')->where('name', 'Roupas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Jeans', 'parent_category'=>ProductCategory::select('id')->where('name', 'Calças')->get()->first()->id]);
        ProductCategory::create(['name'=>'Jaquetas', 'parent_category'=>ProductCategory::select('id')->where('name', 'Roupas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Jeans', 'parent_category'=>ProductCategory::select('id')->where('name', 'Jaquetas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Couro', 'parent_category'=>ProductCategory::select('id')->where('name', 'Jaquetas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Regatas', 'parent_category'=>ProductCategory::select('id')->where('name', 'Camisetas')->get()->first()->id]);
    }
}
