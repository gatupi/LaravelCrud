<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 300);
            $table->double('price');
            $table->timestamps();
        });

        Schema::create('sales', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });

        Schema::create('product_sale', function (Blueprint $table) {
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_id');          
            $table->unsignedInteger('quantity');    
            $table->primary(['sale_id', 'product_id']);        

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sale_id')->references('id')->on('sales');

            $table->unique(['product_id', 'sale_id']); // único produto por venda
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('product_sale');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products');
    }
}
