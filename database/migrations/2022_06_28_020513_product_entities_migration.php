<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductEntitiesMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('brands', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('product_categories', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 60);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('product_categories');
            $table->unique(['name', 'parent_id']);
            $table->timestamps();
        });

        Schema::create('products', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 350);
            $table->double('cost');
            $table->float('margin');
            $table->boolean('applies_margin');
            $table->double('fixed_price');
            $table->double('calculated_price');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('product_categories');
            $table->timestamps();
        });

        Schema::create('product_product_category', function(Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_category_id');
            $table->primary(['product_id', 'product_category_id']);
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
        Schema::dropIfExists('product_product_category');
        Schema::dropIfExists('products');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('product_categories');
    }
}
