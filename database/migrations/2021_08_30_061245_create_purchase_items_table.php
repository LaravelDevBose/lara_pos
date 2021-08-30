<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name')->nullable();
            $table->string('product_unit')->nullable();
            $table->float('item_qty');
            $table->float('pp_without_dis');
            $table->float('discount_percent');
            $table->float('item_price');
            $table->unsignedBigInteger('item_tax_id')->nullable();
            $table->float('item_tax')->default('0.00');
            $table->float('pp_inc_tax')->default('0.00');
            $table->float('sub_total');
            $table->float('total_amount');
            $table->boolean('status')->default(config('constant.active'));
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('purchase_id')
                ->references('purchase_id')
                ->on('purchases')
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
        Schema::dropIfExists('purchase_items');
    }
}
