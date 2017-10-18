<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_invites', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('inviter_id')->nullable();
            $table->string('team_id')->nullable();
            $table->string('status')->default('waiting'); // waiting, declined, accepted
            $table->timestamps();

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
        Schema::dropIfExists('group_invites');
    }
}
