<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('name');
  			$table->float('amount', 12, 2);
  			$table->integer('participants');
  			$table->integer('recurrence')->unsigned();
  			$table->date('start_date');
  			$table->string('status')->default('inactive');
  			$table->timestamps();
            $table->foreign('recurrence')->references('id')->on('recurrences');

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
        Schema::dropIfExists('groups');
    }
}
