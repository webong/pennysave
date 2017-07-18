<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('banks')->insert([
         [ 'name' => 'Access Bank Nig. Ltd', 'logo' => 'images%2Fbank%2Faccess.jpg' ],
         [ 'name' => 'Citibank Nig. Ltd', 'logo' => 'images%2Fbank%2Fciti.jpg' ],
         [ 'name' => 'Diamond Bank Plc', 'logo' => 'images%2Fbank%2Fdiamond.jpg' ],
         [ 'name' => 'Ecobank Nigeria Plc', 'logo' => 'images%2Fbank%2Feco.png' ],
         [ 'name' => 'Fidelity Bank Plc', 'logo' => 'images%2Fbank%2Ffidelity.jpg' ],
         [ 'name' => 'First Bank Plc', 'logo' => 'images%2Fbank%2Ffirst.jpg' ],
         [ 'name' => 'First City Monument Bank Plc', 'logo' => 'images%2Fbank%2Ffcmb.png' ],
         [ 'name' => 'FSDH Merchant Bank', 'logo' => 'images%2Fbank%2Ffsdh.png' ],
         [ 'name' => 'Guaranty Trust Bank Plc', 'logo' => 'images%2Fbank%2Fgt.png' ],
         [ 'name' => 'Heritage Bank', 'logo' => 'images%2Fbank%2Fheritage.jpg' ],
         [ 'name' => 'Jaiz Bank', 'logo' => 'images%2Fbank%2Fjaiz.png' ],
         [ 'name' => 'Keystone Bank', 'logo' => 'images%2Fbank%2Fkeystone.jpg' ],
         [ 'name' => 'Skye Bank Plc', 'logo' => 'images%2Fbank%2Fskye.jpg' ],
         [ 'name' => 'Stanbic IBTC Bank Nig', 'logo' => 'images%2Fbank%2Fstanbicibtc.png' ],
         [ 'name' => 'Standard Chartered Bank Nig. Ltd', 'logo' => 'images%2Fbank%2Fstandardchartered.jpg' ],
         [ 'name' => 'Sterling Bank', 'logo' => 'images%2Fbank%2Fsterling.jpg' ],
         [ 'name' => 'Union Bank Plc', 'logo' => 'images%2Fbank%2Funion.png' ],
         [ 'name' => 'United Bank for Africa', 'logo' => 'images%2Fbank%2Fuba.png' ],
         [ 'name' => 'Unity Bank Plc', 'logo' => 'images%2Fbank%2Funity.jpg' ],
         [ 'name' => 'Wema Bank Plc', 'logo' => 'images%2Fbank%2Fwema.png' ],
         [ 'name' => 'Zenith Bank Plc', 'logo' => 'images%2Fbank%2Fzenith.png' ],
      ]);

    }
}
