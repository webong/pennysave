<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->string('group_id');
  			$table->string('user_id');
  			$table->string('cycle')->default(1);
  			$table->integer('role_id')->unsigned();
  			$table->string('debiting')->nullable();
  			$table->string('crediting')->nullable();
  			$table->string('status')->default('inactive');
  			$table->timestamps();
  			$table->foreign('group_id')->references('id')->on('groups');
  			$table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('debiting')->references('id')->on('accounts');
            $table->foreign('crediting')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
    }
}
