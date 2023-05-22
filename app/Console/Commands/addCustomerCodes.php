<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;
use App\Models\customerCode;
use Illuminate\Support\Facades\DB;

class addCustomerCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'codes:add {--start-count=} {--end-count=} {--store-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

        $start_count = (int)$this->option('start-count');
        if(empty($start_count)){
            $this->error('name cant be empty.');
        }


        $end_count = (int)$this->option('end-count');
        if(empty($start_count)){
            $this->error('name cant be empty.');
        }

        $store_id = $this->option('store-id');
        if(empty($store_id)){
            $this->error('name cant be empty.');
        }

        $store = Store::findOrFail($store_id);

        if($end_count < $start_count){
            $this->error('end count cant be lower than the start count');
        }

        $array_of_codes = [];
        for ($x = $start_count ; $x <= $end_count; $x++) {
            array_push($array_of_codes,array('code' => "HB" . $x,'store_id' => $store_id));
        }

        DB::table('customer_codes')->insert($array_of_codes);

        return Command::SUCCESS;
    }
}
