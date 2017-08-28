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
         [ 'id' => NULL, 'code' => '044', 'name' => 'Access Bank', 'logo' => 'images%2Fbank%2Faccess.jpg' ],
         [ 'id' => NULL, 'code' => '023', 'name' => 'Citibank Nigeria', 'logo' => 'images%2Fbank%2Fciti.jpg' ],
         [ 'id' => NULL, 'code' => '063', 'name' => 'Diamond Bank', 'logo' => 'images%2Fbank%2Fdiamond.jpg' ],
         [ 'id' => NULL, 'code' => '050', 'name' => 'Ecobank Nigeria', 'logo' => 'images%2Fbank%2Feco.png' ],
         [ 'id' => NULL, 'code' => '084', 'name' => 'Enterprise Bank', 'logo' => 'images%2Fbank%2Fenterprise-bank.jpg' ],
         [ 'id' => NULL, 'code' => '070', 'name' => 'Fidelity Bank', 'logo' => 'images%2Fbank%2Ffidelity.jpg' ],
         [ 'id' => NULL, 'code' => '011', 'name' => 'First Bank', 'logo' => 'images%2Fbank%2Ffirst.jpg' ],
         [ 'id' => NULL, 'code' => '214', 'name' => 'First City Monument Bank', 'logo' => 'images%2Fbank%2Ffcmb.png' ],
         [ 'id' => NULL, 'code' => '058', 'name' => 'Guaranty Trust Bank', 'logo' => 'images%2Fbank%2Fgt.png' ],
         [ 'id' => NULL, 'code' => '030', 'name' => 'Heritage Bank', 'logo' => 'images%2Fbank%2Fheritage.jpg' ],
         [ 'id' => NULL, 'code' => '301', 'name' => 'Jaiz Bank', 'logo' => 'images%2Fbank%2Fjaiz.png' ],
         [ 'id' => NULL, 'code' => '082', 'name' => 'Keystone Bank', 'logo' => 'images%2Fbank%2Fkeystone.jpg' ],
         [ 'id' => NULL, 'code' => '014', 'name' => 'Mainstreet Bank', 'logo' => 'images%2Fbank%2Fmainstreet-bank.jpg' ],
         [ 'id' => NULL, 'code' => '076', 'name' => 'Providus Bank', 'logo' => 'images%2Fbank%2Fprovidus-bank.png' ],
         [ 'id' => NULL, 'code' => '076', 'name' => 'Skye Bank', 'logo' => 'images%2Fbank%2Fskye.jpg' ],
         [ 'id' => NULL, 'code' => '221', 'name' => 'Stanbic IBTC Bank', 'logo' => 'images%2Fbank%2Fstanbicibtc.png' ],
         [ 'id' => NULL, 'code' => '068', 'name' => 'Standard Chartered Bank', 'logo' => 'images%2Fbank%2Fstandardchartered.jpg' ],
         [ 'id' => NULL, 'code' => '232', 'name' => 'Sterling Bank', 'logo' => 'images%2Fbank%2Fsterling.jpg' ],
         [ 'id' => NULL, 'code' => '032', 'name' => 'Union Bank', 'logo' => 'images%2Fbank%2Funion.png' ],
         [ 'id' => NULL, 'code' => '033', 'name' => 'United Bank for Africa', 'logo' => 'images%2Fbank%2Fuba.png' ],
         [ 'id' => NULL, 'code' => '215', 'name' => 'Unity Bank', 'logo' => 'images%2Fbank%2Funity.jpg' ],
         [ 'id' => NULL, 'code' => '035', 'name' => 'Wema Bank', 'logo' => 'images%2Fbank%2Fwema.png' ],
         [ 'id' => NULL, 'code' => '057', 'name' => 'Zenith Bank', 'logo' => 'images%2Fbank%2Fzenith.png' ],
      ]);

    }
}
