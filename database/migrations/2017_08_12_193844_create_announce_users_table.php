<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnounceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announce_users', function (Blueprint $table) {
            $table->string('announce_id');
            $table->string('team_id')->nullable();
            $table->string('user_id');
            $table->boolean('status');
            $table->foreign('announce_id')->references('id')->on('announcements');
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
        Schema::dropIfExists('announce_users');
    }
}
