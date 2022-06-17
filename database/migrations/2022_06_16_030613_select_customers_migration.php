<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Database\DbContextFileProcessor;

class SelectCustomersMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(DbContextFileProcessor::create_fn_content('mask_cpf'));
        DB::statement(DbContextFileProcessor::create_sp_content('select_customers'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement(DbContextFileProcessor::drop_sp_content('select_customers'));
        DB::statement(DbContextFileProcessor::drop_fn_content('mask_cpf'));
    }
}
