<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->unsignedBigInteger('sell_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name')->nullable();
            $table->text('product_note')->nullable();
            $table->string('product_unit')->nullable();
            $table->float('item_qty');
            $table->float('item_price');
            $table->boolean('discount_type');
            $table->float('discount_amount');
            $table->float('sub_total');
            $table->unsignedBigInteger('item_tax_id')->nullable();
            $table->float('item_tax')->default('0.00');
            $table->float('price_inc_tax')->default('0.00');
            $table->float('total_amount');
            $table->boolean('status')->default(config('constant.active'));
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sell_id')
                ->references('sell_id')
                ->on('sells')
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
        Schema::dropIfExists('sell_items');
    }
}
