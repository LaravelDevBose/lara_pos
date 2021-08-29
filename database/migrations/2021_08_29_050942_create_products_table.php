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
            $table->string('barcode');
            $table->string('product_reference');
            $table->text('short_description');
            $table->text('long_description')->nullable();
            $table->unsignedTinyInteger('profit_margin');
            $table->unsignedTinyInteger('product_tva');
            $table->unsignedTinyInteger('min_stock');
            $table->unsignedTinyInteger('max_stock');
            $table->boolean('product_type')->default(\App\Models\Product::TYPES['Single']);
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
