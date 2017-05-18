<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurrences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('period');
        });

        DB::table('recurrences')->insert([
           [ 'period' => 'Daily' ],
           [ 'period' => 'Weekly' ],
           [ 'period' => 'Fortnightly' ],
           [ 'period' => 'Monthly' ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recurrences');
    }
}
