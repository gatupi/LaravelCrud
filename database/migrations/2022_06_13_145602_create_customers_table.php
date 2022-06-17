<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('cpf', 11)->unique();
            $table->string('first_name', 30);
            $table->string('middle_name', 40)->nullable();
            $table->string('last_name', 30);
            $table->date('date_of_birth');
            $table->char('sex', 1);
            $table->boolean('active')->default(true);
            $table->datetime('inactive_since')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('customers');
    }
}
