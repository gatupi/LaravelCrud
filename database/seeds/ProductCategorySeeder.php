<?php

use App\Models\Product;
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
        ProductCategory::create(['name'=>'Produtos', 'parent_id'=>null]);
        ProductCategory::create(['name'=>'Roupas', 'parent_id'=>1]);
        ProductCategory::create(['name'=>'Camisetas', 'parent_id'=>ProductCategory::select('id')->where('name', 'Roupas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Calças', 'parent_id'=>ProductCategory::select('id')->where('name', 'Roupas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Jeans', 'parent_id'=>ProductCategory::select('id')->where('name', 'Calças')->get()->first()->id]);
        ProductCategory::create(['name'=>'Jaquetas', 'parent_id'=>ProductCategory::select('id')->where('name', 'Roupas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Jeans', 'parent_id'=>ProductCategory::select('id')->where('name', 'Jaquetas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Couro', 'parent_id'=>ProductCategory::select('id')->where('name', 'Jaquetas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Regatas', 'parent_id'=>ProductCategory::select('id')->where('name', 'Camisetas')->get()->first()->id]);
        ProductCategory::create(['name'=>'Acessórios', 'parent_id'=>1]);
    }
}
