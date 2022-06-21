<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        for($i=0; $i<1001; $i++) {
            $c = PopulateHelper::randomCustomer();
            $c->save();
        }
    }
}

class PopulateHelper {

    private const FIRST_NAMES = [
		['sex'=>'m', 'name'=>'Gabriel'],
		['sex'=>'m', 'name'=>'Raphael'],
		['sex'=>'m', 'name'=>'Miguel'],
		['sex'=>'f', 'name'=>'Aline'],
		['sex'=>'f', 'name'=>'Mariana'],
		['sex'=>'m', 'name'=>'Fabiano'],
		['sex'=>'f', 'name'=>'Márcia'],
		['sex'=>'m', 'name'=>'Gilberto'],
		['sex'=>'m', 'name'=>'Douglas'],
		['sex'=>'f', 'name'=>'Yolanda'],
		['sex'=>'m', 'name'=>'Roberto'],
		['sex'=>'m', 'name'=>'Ronaldo']
    ];
    private const LAST_NAMES = ['Alonso', 'Malaguti', 'Oliveira', 'Silva', 'Carvalho', 'Gomes', 'Souza', 'de Paula', 'da Silva', 'Capocci'];

    public static function randomName() {
        $fname = self::FIRST_NAMES[rand(0, count(self::FIRST_NAMES) - 1)];
        $lname = self::LAST_NAMES[rand(0, count(self::LAST_NAMES) - 1)];
        $name = ['sex'=>$fname['sex'], 'fname'=>$fname['name'], 'mname'=>null, 'lname'=>$lname];

        return $name;
    }

    public static function randomDate() {
        $year = str_pad(strval(rand(1980, 2002)), 4, '0', STR_PAD_LEFT);
        $month = str_pad(strval(rand(1, 12)), 2, '0', STR_PAD_LEFT);
        $day = str_pad(strval(rand(1, 28)), 2, '0', STR_PAD_LEFT);

        return "$day/$month/$year";
    }

    public static function randomBool() {
        return rand(1,1000)%2 == 0;
    }

    public static function randomNumericString($length) {
        $str = '';
        for($i=0; $i<$length; $i++) {
            $str .= rand(0,9);
        }
        return $str;
    }

    public static function randomCustomer() {
        $customer = new Customer();
        $name = self::randomName();
        $customer->first_name = $name['fname'];
        $customer->last_name = $name['lname'];
        $customer->sex = $name['sex'];
        $customer->date_of_birth = self::randomDate();
        $customer->active = self::randomBool();
        $customer->cpf = self::randomNumericString(11);
        return $customer;
    }
}

for($i=0; $i<15; $i++) {
    echo print_r(PopulateHelper::randomCustomer(), true) . "\n";
}
