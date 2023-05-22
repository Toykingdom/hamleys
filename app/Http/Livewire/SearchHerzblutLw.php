<?php

namespace App\Http\Livewire;

use App\Services\Herzblut\Facades\Trader;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SearchHerzblutLw extends Component
{

    public $term;

    public $results = [];

    public $notification = '';
    public $notification_type = "";

    protected $rules = [
        'term' => 'required|min:4',
    ];

    //   array:1 [▼
    //   0 => App\Services\Herzblut\TraderCustomer {#1565 ▼
    //     +account_number: "HBTEST4"
    //     +first_name: "HENRY"
    //     +last_name: "HERZBLUT"
    //     +mobile_number: "0836640754"
    //     +email: "HENRY+TESTTK@HERZBLUT.CO.ZA"
    //     +store_name: "HBTEST store name 1"
    //   }
    // ]

    public function mount()
    {
        if (!empty($this->term)) {
            $validatedData = $this->validate();
            $this->results = Trader::searchCustomers($validatedData['term']);
        }
    }

    public function submit()
    {
        $validatedData = $this->validate();
        // dd($validatedData);
        // #TODO
        // make a request to the search service
        // $users = [array('name'=> 'Henry','code'=> '135','email' => 'henry@herzblut.co.za'),array('name'=> 'Henry','code'=> '135','email' => 'henry@herzblut.co.za')];
        // HBTEST4

        try {
            Log::info('sending request searching customer');
            $this->results = Trader::searchCustomers($validatedData['term']);
            //     dd($result);
        } catch (Throwable $e) {
            report($e);
            Log::info('error creating customer');
            return false;
        }

        // $result = Trader::fetchCustomer("HBTEST4");
        //   dd($this->results);
        // $this->dispatchBrowserEvent('alert',
        // ['type' => 'error',  'message' => 'Something is Wrong!']);
        // $this->results = $users;

        // Add registration data to modal
        // $this->$showChild = true;
        // return redirect()->route('print_cards', ['customer_code' => $this->account_code]);
    }

    public function render()
    {
        // sleep(1);
        // $users = [array('name'=> 'Henry','code'=> '135','email' => 'henry@herzblut.co.za')];

        // $data = [
        //     'users' => $users,
        // ];
        return view('livewire.search-herzblut-lw');
    }
}
