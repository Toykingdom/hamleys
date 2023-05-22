<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $codes = [
            1 => [20000001, 20010000],
            2 => [20010001, 20020000],
            3 => [20020001, 20030000],
            4 => [20030001, 20040000],
            5 => [20040001, 20050000],
            6 => [20050001, 20060000],
            7 => [20060001, 20070000]
        ];

        $code_prefix = (App::environment('production')) ? '' : 'HB';

        foreach($codes as $store_id => $range) {
            $start_count = $range[0];
            $end_count = $range[1];
            $store = Store::findOrFail($store_id);

            $array_of_codes = [];
            for ($x = $start_count ; $x <= $end_count; $x++) {
                array_push($array_of_codes,array('code' => $code_prefix . $x,'store_id' => $store_id));
            }

            DB::table('customer_codes')->insert($array_of_codes);
        }
    }
}
