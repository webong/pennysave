<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->string('logo');
        });

        DB::table('banks')->insert([
           [ 'name' => 'Access Bank Nig. Ltd', 'logo' => 'img/bank/access.jpg' ],
           [ 'name' => 'Citibank Nig. Ltd', 'logo' => 'img/bank/citi.jpg' ],
           [ 'name' => 'Diamond Bank Plc', 'logo' => 'img/bank/diamond.jpg' ],
           [ 'name' => 'Ecobank Nigeria Plc', 'logo' => 'img/bank/eco.png' ],
           [ 'name' => 'Fidelity Bank Plc', 'logo' => 'img/bank/fidelity.jpg' ],
           [ 'name' => 'First Bank Plc', 'logo' => 'img/bank/first.jpg' ],
           [ 'name' => 'First City Monument Bank Plc', 'logo' => 'img/bank/fcmb.png' ],
           [ 'name' => 'FSDH Merchant Bank', 'logo' => 'img/bank/fsdh.png' ],
           [ 'name' => 'Guaranty Trust Bank Plc', 'logo' => 'img/bank/gt.png' ],
           [ 'name' => 'Heritage Bank', 'logo' => 'img/bank/heritage.jpg' ],
           [ 'name' => 'Keystone Bank', 'logo' => 'img/bank/keystone.jpg' ],
           [ 'name' => 'Skye Bank Plc', 'logo' => 'img/bank/skye.jpg' ],
           [ 'name' => 'Stanbic IBTC Bank Nig', 'logo' => 'img/bank/stanbicibtc.png' ],
           [ 'name' => 'Standard Chartered Bank Nig. Ltd', 'logo' => 'img/bank/standardchartered.jpg' ],
           [ 'name' => 'Sterling Bank', 'logo' => 'img/bank/sterling.jpg' ],
           [ 'name' => 'Union Bank Plc', 'logo' => 'img/bank/union.png' ],
           [ 'name' => 'United Bank for Africa', 'logo' => 'img/bank/uba.png' ],
           [ 'name' => 'Unity Bank Plc', 'logo' => 'img/bank/unity.jpg' ],
           [ 'name' => 'Wema Bank Plc', 'logo' => 'img/bank/wema.png' ],
           [ 'name' => 'Zenith Bank Plc', 'logo' => 'img/bank/zenith.png' ],
        ]);
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('banks');
     }
}
