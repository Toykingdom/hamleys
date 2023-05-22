<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $stores = [
            ['id' => 1, 'name' => 'Hamleys Bedfordview'],
            ['id' => 2, 'name' => 'Hamleys Eastgate'],
            ['id' => 3, 'name' => 'Hamleys Fourways'],
            ['id' => 4, 'name' => 'Hamleys Rosebank'],
            ['id' => 5, 'name' => 'Hamleys Sandton'],
            ['id' => 6, 'name' => 'Hamleys Gateway'],
            ['id' => 7, 'name' => 'Hamleys V&A Waterfront']
        ];

        foreach($stores as $store) {
            Store::create($store);
        }
    }
}
