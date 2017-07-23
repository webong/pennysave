<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Account Details for making payments to Users
        Schema::create('user_payment_receipient_account', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('user_id');
            $table->string('account_name');
            $table->string('account_no');
            $table->integer('bank_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bank_id')->references('id')->on('banks');

            $table->primary(['user_id', 'bank_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_payment_receipient_account');
    }
}