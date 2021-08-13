<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id('bank_acc_id');
            $table->string('acc_holder_name');
            $table->string('account_number');
            $table->boolean('account_type')->default(\App\Models\BankAccount::AccountTypes['Saving Account']);
            $table->float('opening_balance')->default(0.00);
            $table->longText('account_details')->nullable();
            $table->text('account_note')->nullable();
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
        Schema::dropIfExists('bank_accounts');
    }
}
