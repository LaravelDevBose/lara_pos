<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('purchase_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('location_id');
            $table->string('reference_no');
            $table->dateTime('purchase_date')->useCurrent();
            $table->unsignedInteger('total_qty');
            $table->float('subtotal');
            $table->boolean('discount_type')->default(config('constant.discountType.None'));
            $table->float('discount_amount')->default('0.00');
            $table->unsignedBigInteger('tax_id');
            $table->float('purchase_tax')->default('0.00');
            $table->float('total_amount');
            $table->boolean('pay_term_number')->default(15);
            $table->boolean('pay_term_type')->default(config('constant.pay_terms_type.Days'));
            $table->boolean('purchase_status')->default(\App\Models\Purchase::PurchaseStatus['Ordered']);
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
        Schema::dropIfExists('purchases');
    }
}
