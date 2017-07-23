<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_refs', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->string('id');
            $table->string('message_id');
            $table->string('team_id');
            $table->string('sender');
            $table->string('receiver')->nullable();
            $table->string('sender_status');
            $table->string('receiver_status');
            $table->string('status')->nullable();
            $table->string('attachments_csv')->nullable();
            $table->timestamps();
            $table->foreign('message_id')->references('id')->on('messages');
            $table->foreign('team_id')->references('id')->on('groups');
            $table->foreign('sender')->references('id')->on('users');
           
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
        Schema::dropIfExists('message_refs');
    }
}
