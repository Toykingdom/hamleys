<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;

class AddStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:add {--name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a store';

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
      $name = $this->option('name');
      if(empty($name)){
          $this->error('name cant be empty.');
      }

      $store = new Store;

      try {
          $store->name = $name;
          $store->save();
      } catch (\Throwable $th) {
          $this->error( $th);

      }


      return Command::SUCCESS;
    }
}
// php artisan store:add --name="store name 1"