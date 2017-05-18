<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_saves', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->float('taget_amount', 9, 2);
            $table->float('instalment_amount');
            $table->date('target_date');
            $table->string('recurrence');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_saves');
    }
}
