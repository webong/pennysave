<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallets', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('user_id');
            $table->float('cleared_balance', 12, 2);
            $table->float('uncleared_balance', 12, 2);
            $table->string('plan_attached_to');
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
        Schema::dropIfExists('user_wallets');
    }
}
