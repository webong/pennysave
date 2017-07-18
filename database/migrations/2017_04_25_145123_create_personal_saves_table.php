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
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('user_id');
            $table->string('name');
            $table->float('target_amount', 12, 2)->nullable();
            $table->float('instalment_amount', 12, 2);
            $table->date('target_date')->nullable();
            $table->date('start_date');
            $table->integer('recurrence')->unsigned();
            $table->integer('priority_level')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('recurrence')->references('id')->on('recurrences');
            $table->foreign('priority_level')->references('id')->on('priority_levels');

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
        Schema::dropIfExists('personal_saves');
    }
}
