<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('barcode');
            $table->unsignedBigInteger('unit_id');
            $table->float('alert_qty')->nullable();
            $table->text('short_description')->nullable();
            $table->unsignedTinyInteger('tax_id');
            $table->boolean('product_type')->default(\App\Models\Product::TYPES['Single']);
            $table->float('product_dpp');
            $table->float('product_dpp_inc_tax');
            $table->unsignedTinyInteger('profit_percent');
            $table->float('product_dsp');
            $table->boolean('status')->default(config('constant.active'));
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
        Schema::dropIfExists('products');
    }
}
