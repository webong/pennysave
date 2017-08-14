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
         [ 'id' => 1, 'name' => 'Access Bank Nig. Ltd', 'logo' => 'images%2Fbank%2Faccess.jpg' ],
         [ 'id' => 2, 'name' => 'Citibank Nig. Ltd', 'logo' => 'images%2Fbank%2Fciti.jpg' ],
         [ 'id' => 3, 'name' => 'Diamond Bank Plc', 'logo' => 'images%2Fbank%2Fdiamond.jpg' ],
         [ 'id' => 4, 'name' => 'Ecobank Nigeria Plc', 'logo' => 'images%2Fbank%2Feco.png' ],
         [ 'id' => 5, 'name' => 'Fidelity Bank Plc', 'logo' => 'images%2Fbank%2Ffidelity.jpg' ],
         [ 'id' => 6, 'name' => 'First Bank Plc', 'logo' => 'images%2Fbank%2Ffirst.jpg' ],
         [ 'id' => 7, 'name' => 'First City Monument Bank Plc', 'logo' => 'images%2Fbank%2Ffcmb.png' ],
         [ 'id' => 8, 'name' => 'FSDH Merchant Bank', 'logo' => 'images%2Fbank%2Ffsdh.png' ],
         [ 'id' => 9, 'name' => 'Guaranty Trust Bank Plc', 'logo' => 'images%2Fbank%2Fgt.png' ],
         [ 'id' => 10, 'name' => 'Heritage Bank', 'logo' => 'images%2Fbank%2Fheritage.jpg' ],
         [ 'id' => 11, 'name' => 'Jaiz Bank', 'logo' => 'images%2Fbank%2Fjaiz.png' ],
         [ 'id' => 12, 'name' => 'Keystone Bank', 'logo' => 'images%2Fbank%2Fkeystone.jpg' ],
         [ 'id' => 13, 'name' => 'Skye Bank Plc', 'logo' => 'images%2Fbank%2Fskye.jpg' ],
         [ 'id' => 14, 'name' => 'Stanbic IBTC Bank Nig', 'logo' => 'images%2Fbank%2Fstanbicibtc.png' ],
         [ 'id' => 15, 'name' => 'Standard Chartered Bank Nig. Ltd', 'logo' => 'images%2Fbank%2Fstandardchartered.jpg' ],
         [ 'id' => 16, 'name' => 'Sterling Bank', 'logo' => 'images%2Fbank%2Fsterling.jpg' ],
         [ 'id' => 17, 'name' => 'Union Bank Plc', 'logo' => 'images%2Fbank%2Funion.png' ],
         [ 'id' => 18, 'name' => 'United Bank for Africa', 'logo' => 'images%2Fbank%2Fuba.png' ],
         [ 'id' => 19, 'name' => 'Unity Bank Plc', 'logo' => 'images%2Fbank%2Funity.jpg' ],
         [ 'id' => 20, 'name' => 'Wema Bank Plc', 'logo' => 'images%2Fbank%2Fwema.png' ],
         [ 'id' => 21, 'name' => 'Zenith Bank Plc', 'logo' => 'images%2Fbank%2Fzenith.png' ],
      ]);

    }
}
