<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->string('unique_code');
            $table->string('contact_type')->default('customer');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('business_name')->nullable();
            $table->string('mobile_no')->unique();
            $table->string('alt_phone_no')->nullable();
            $table->string('email')->nullable();
            $table->date('contact_dob')->nullable();
            $table->float('open_balance')->default(0);
            $table->unsignedTinyInteger('pay_term_num')->nullable();
            $table->boolean('pay_term_type')->nullable();
            $table->float('credit_limit')->nullable()->default(0);
            $table->string('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
