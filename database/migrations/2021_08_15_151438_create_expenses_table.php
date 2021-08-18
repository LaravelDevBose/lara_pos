<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id('expense_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('head_id')->nullable();
            $table->string('reference_no');
            $table->dateTime('expense_date')->useCurrent();
            $table->unsignedBigInteger('expense_for')->nullable();
            $table->float('total_amount');
            $table->text('expense_note')->nullable();
            $table->boolean('payment_status')->default(\App\Models\Payment::PaymentStatus['Paid']);
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
        Schema::dropIfExists('expenses');
    }
}
