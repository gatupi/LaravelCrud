<?php

use Illuminate\Database\Seeder;
use App\Database\PopulateHelper;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0; $i<1001; $i++) {
            $c = PopulateHelper::randomCustomer();
            $c->save();
        }
    }
}
