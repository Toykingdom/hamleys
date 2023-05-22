<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Store;
use App\Models\userStores;
use Illuminate\Support\Facades\Hash;

class AddStoreUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addstoreuser:add  {--email-address=} {--password=} {--store-user-name=}  {--store-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add store used with store id';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email_address = $this->option('email-address');
        if(empty($email_address)){
            $this->error('Email address cant be empty.');
        }
        $password = $this->option('password');
        if(empty($password)){
            $this->error('Password cant be empty.');
        }
        $store_user_name = $this->option('store-user-name');
        if(empty($store_user_name)){
            $this->error('Store user name cant be empty.');
        }

        $store_id = $this->option('store-id');
        if(empty($store_id)){
            $this->error('Store id can not be empty');
        }



        // check if store id exists
        $store = Store::findOrFail($store_id);

        if(empty($store )){
            $this->error('Store user name cant be empty.');
        }


        $user = new User();
        try {
          $hash_password = Hash::make($password);
          $user->name = $store_user_name;
          $user->email = $email_address;
          $user->email_verified_at = now();
          $user->password = $hash_password;
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
        return Command::SUCCESS;
    }
}
// php artisan addstoreuser:add --email-address='test@me.com' --password="testtest1" --store-user-name="store user rname" --store-id=1