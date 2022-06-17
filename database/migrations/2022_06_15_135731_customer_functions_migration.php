<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Database\DbContextFileProcessor;

class CustomerFunctionsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        DB::statement(DbContextFileProcessor::create_fn_content('calculate_age'));
        DB::statement(DbContextFileProcessor::create_fn_content('get_customer_age'));
        DB::statement(DbContextFileProcessor::create_fn_content('get_customer_fullname'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(DbContextFileProcessor::drop_fn_content('get_customer_fullname'));
        DB::statement(DbContextFileProcessor::drop_fn_content('get_customer_age'));
        DB::statement(DbContextFileProcessor::drop_fn_content('calculate_age'));
    }
}
