<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
        
            $table->string('id');
            $table->string('user_id');
            $table->string('account_type');
            $table->string('type_details');
            $table->string('last_four_digits');
            $table->string('authorization_token')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
