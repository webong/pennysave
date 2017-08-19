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
        /* 
         *  Using completed_cycle, you can determine the current_cycle, since the current-cycle
         *  will be greater than the completed_cycle by 1 at least. (This does not take into 
         *  account uncompleted cycles, at least for the present)
         */
        Schema::create('groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('name');
  			$table->float('amount', 12, 2);
  			$table->integer('completed_cycle')->default(0);
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
