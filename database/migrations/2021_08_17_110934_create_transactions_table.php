<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->morphs('transactionable');
            $table->float('amount');
            $table->dateTime('transaction_date');
            $table->boolean('method')->default(\App\Models\Transaction::Methods['Cash']);
            $table->unsignedBigInteger('account_id')->nullable();
            $table->text('method_details')->nullable();
            $table->text('transaction_note')->nullable();
            $table->boolean('transaction_type')->default(\App\Models\Transaction::Types['Cr']);
            $table->boolean('transaction_for')->default(\App\Models\Transaction::Models['Expense']);
            $table->boolean('status')->default(config('constant.inactive'));
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
        Schema::dropIfExists('transactions');
    }
}
