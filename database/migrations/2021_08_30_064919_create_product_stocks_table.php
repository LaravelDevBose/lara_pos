<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id('stock_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('product_id');
            $table->float('current_stock');
            $table->timestamps();

            $table->foreign('location_id')
                ->references('location_id')
                ->on('business_locations')
                ->cascadeOnDelete();

            $table->foreign('product_id')
                ->references('product_id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stocks');
    }
}
