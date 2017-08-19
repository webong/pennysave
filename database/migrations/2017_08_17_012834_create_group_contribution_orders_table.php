<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupContributionOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_contribution_orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->tinyInteger('order');
            $table->string('team_id');
            $table->string('user_id');
            $table->integer('current_cycle');
            $table->date('schedule_date');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_contribution_orders');
    }
}
