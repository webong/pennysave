<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SavingsRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Savings Records for User's Personal Savings being made
        Schema::create('savings_records', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('user_id');
            $table->string('savings_plan_id');
            $table->float('amount', 12, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('savings_plan_id')->references('id')->on('personal_saves');

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
        Schema::dropIfExists('savings_records');
    }
}
