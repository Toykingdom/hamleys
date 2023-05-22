<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use App\Models\userStores;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $logins = [
            ['store_id' => 1, 'email' => 'bedford.hamleys@htoys.co.za', 'password' => 'H@mB3d!'],
            ['store_id' => 2, 'email' => 'eastgate.hamleys@htoys.co.za', 'password' => 'H@m3@st!'],
            ['store_id' => 3, 'email' => 'fourways.hamleys@htoys.co.za', 'password' => 'H@mfou4!'],
            ['store_id' => 4, 'email' => 'rosebank.hamleys@htoys.co.za', 'password' => 'H@mR0se!'],
            ['store_id' => 5, 'email' => 'sandton.hamleys@htoys.co.za', 'password' => 'H@mS@nd!'],
            ['store_id' => 6, 'email' => 'gateway.hamleys@htoys.co.za', 'password' => 'H@mG@t3!'],
            ['store_id' => 7, 'email' => 'vawaterfront.hamleys@htoys.co.za', 'password' => 'H@mV&A!']
        ];

        foreach($logins as $login) {
            // check if store id exists
            $store = Store::findOrFail($login['store_id']);

            if(empty($store )){
                $this->error('Store user name cant be empty.');
            }


            $user = new User();
            try {
                $user->name = $store->name;
                $user->email = $login['email'];
                $user->email_verified_at = now();
                $user->password = Hash::make($login['password']);
                $user->save();
            } catch (\Throwable $th) {
                $this->error( $th);
            }

            $link_user_store = new userStores();
            $link_user_store->user_id = $user->id;
            $link_user_store->store_id = $store->id;

            try {
                $link_user_store->save();
            } catch (\Throwable $th) {
                $this->error( $th);
            }
        }
    }
}
