<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\customerCode;
use App\Services\Herzblut\Facades\Trader;
use Throwable;
use Klaviyo\Klaviyo as Klaviyo;
use Klaviyo\Model\EventModel as KlaviyoEvent;
use Klaviyo\Model\ProfileModel as KlaviyoProfile;
class AdduserHerzblutLw extends Component
{

    public $user;

    public $store_consultant_name;
    public $first_name;
    public $last_name;
    public $email;
    public $mobile_number;
    public $store;
    public $store_name;
    public $store_id;
    public $customer_type_id;
    public $stores;

    public $account_code;

    protected $rules = [
        'store_consultant_name' => 'required',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'required|email:filter',
        'mobile_number' => 'required|numeric|digits:10|starts_with:0'
    ];

    public function mount(){
        $this->store_consultant_name = "";
        //
        if ($this->user->is_admin) {
            $store = Store::get()->first();
        } else {
            $user_store = DB::table('user_stores')->where('user_id', $this->user->id)->first();
            $store = Store::find($user_store->store_id);
        }

        $this->store_id = $store->id;
        $this->store_name =  $store->name;
        $this->customer_type_id = 28; // @TODO find a better way to make this configurable
        $this->stores = Store::where('id', '!=', 8)->get();

    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
    }

    public function submit() {

        $validatedData = $this->validate();
        $customer_codem =  new customerCode();
        $customer_code = $customer_codem->reserveCode($this->store_id);
        $store = Store::find($this->store_id);


        $create_customer = ["account_number" => $customer_code->code,
            "first_name" => $validatedData['first_name'],
            "last_name" => $validatedData['last_name'],
            "mobile_number" => $validatedData['mobile_number'],
            "email" => $validatedData['email'],
            "store_name" => $store->name,
            "customer_type_id" => $this->customer_type_id,
        ];

        // Add registration data to modal
        $result = '';
        try {
            Log::info('sending request creating customer');
            $result = Trader::saveCustomer( $create_customer);
        } catch (Throwable $e) {
            report($e);
            Log::info('error creating customer');
            return false;
        }

        // successfully added the customer update the customer_code in the db to used (3)
        $lock_code = $customer_codem->lockCode($customer_code->id);


        Log::info('creating Klaviyo profile');
        $profile = new KlaviyoProfile(
            array(
                '$email' => $validatedData['email'],
                'Account Number' =>  $customer_code->code,
                '$first_name' => $validatedData['first_name'],
                '$last_name' => $validatedData['last_name'],
                '$phone_number' => $validatedData['mobile_number'],
                'Store Name' => $store->name
            )
        );

        //
        $client = new Klaviyo( config('klaviyo.private_key'), config('klaviyo.public_key') );
        $resp = $client->publicAPI->identify( $profile, true );
        $client->lists->addSubscribersToList( config('klaviyo.list_id'), array($profile) );
        Log::info('created Klaviyo profile');
        if($resp == "1"){
            $this->dispatchBrowserEvent('alert',
        ['type' => 'success',  'message' => 'Registered User' ]);
        }

        // if the customer was added successfully
        return redirect()->route('print_cards', ['customer_code' => $customer_code->code]);
    }


    public function render()
    {
        return view('livewire.adduser-herzblut-lw');
    }
}
