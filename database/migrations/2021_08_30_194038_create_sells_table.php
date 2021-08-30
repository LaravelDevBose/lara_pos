<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id('sell_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('reference_no');
            $table->dateTime('sell_date')->useCurrent();
            $table->unsignedInteger('total_qty');
            $table->boolean('discount_type')->default(config('constant.discountType.None'));
            $table->float('discount_amount')->default('0.00');
            $table->float('subtotal');
            $table->unsignedBigInteger('tax_id');
            $table->float('tax_amount')->default('0.00');
            $table->float('shipping_charge')->default(0);
            $table->float('total_amount');
            $table->boolean('pay_term_number')->default(15);
            $table->boolean('pay_term_type')->default(config('constant.pay_terms_type.Days'));
            $table->text('sale_note')->nullable();
            $table->text('shipping_details')->nullable();
            $table->text('shipping_address')->nullable();
            $table->boolean('shipping_status')->default(\App\Models\Sell::ShippingStatus['Ordered']);
            $table->boolean('sell_status')->default(\App\Models\Sell::SellStatus['Final']);
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
        Schema::dropIfExists('sells');
    }
}
