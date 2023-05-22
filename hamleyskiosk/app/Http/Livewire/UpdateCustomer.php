<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\Herzblut\Facades\Trader;
use Illuminate\Support\Facades\Log;
use Klaviyo\Klaviyo as Klaviyo;
use Klaviyo\Model\EventModel as KlaviyoEvent;

class UpdateCustomer extends Component
{
    public $showChild;
    public $store_consultant_name;
    public $first_name;
    public $last_name;
    public $email;
    public $mobile_number;
    public $store;
    public $store_name;
    public $store_id;
    public $print_cards;
    public $customer_type_id;

    public $account_number;

    protected $rules = [
        'account_number' => 'required|max:255',
        'first_name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'required|email:filter',
        'mobile_number' => 'required|numeric|digits:10|starts_with:0',
        'store_name' => 'required|string|max:255',
    ];

    // App\Services\Herzblut\TraderCustomer {#1514 ▼
    //     +account_number: "HBTEST4"
    //     +first_name: "HENRY"
    //     +last_name: "HERZBLUT"
    //     +mobile_number: "0836640754"
    //     +email: "HENRY+TESTTK@HERZBLUT.CO.ZA"
    //     +store_name: "HBTEST store name 1"
    //   }

    public function mount()
    {

        $result = Trader::fetchCustomer($this->account_number);

        $this->first_name = $result->first_name;
        $this->last_name = $result->last_name;
        $this->mobile_number = $result->mobile_number;
        $this->store_name = $result->store_name;
        $this->email = $result->email;
        $this->print_cards = false;
        $this->customer_type_id = 28;

    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save_and_print()
    {
        $this->print_cards = true;
        $this->submit();
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $update_customer = ["account_number" => $this->account_number,
            "first_name" => $validatedData['first_name'],
            "last_name" => $validatedData['last_name'],
            "mobile_number" => $validatedData['mobile_number'],
            "email" => $validatedData['email'],
            "store_name" => $this->store_name,
            "customer_type_id" => $this->customer_type_id,
        ];

        $result = '';
        try {
            if (Trader::saveCustomer($update_customer)) {

                $this->dispatchBrowserEvent('alert',
                    ['type' => 'success', 'message' => 'Customer:' . $this->account_number . ' updated ']);

                // Add Klaviyo event after update
                $event = new KlaviyoEvent(
                    array(
                        'event' => 'Updated Details at Kiosk',
                        'customer_properties' => array(
                            '$email' => $this->email,
                            'Account Number' => $this->account_number,
                            '$first_name' => $validatedData['first_name'],
                            '$last_name' => $validatedData['last_name'],
                            '$phone_number' => $validatedData['mobile_number'],
                            'Store Name' => $this->store_name
                        ),
                        'properties' => array('updating' => true)
                    )
                );

                //
                $client = new Klaviyo(config('klaviyo.private_key'), config('klaviyo.public_key'));
                $resp = $client->publicAPI->track($event, true);

                if ($resp == "1") {
                    $this->dispatchBrowserEvent('alert',
                        ['type' => 'success', 'message' => 'Submitted Update event to Klaviyo']);
                }

                if ($this->print_cards) {
                    return redirect()->route('print_cards', ['customer_code' => $this->account_number]);
                } else {
                    return redirect()->route('search', ['term' => $this->account_number]);
                }

            } else {
                $this->dispatchBrowserEvent('alert', ['type' => 'warning', 'message' => 'Failure when communicating with Trader, could not update Customer']);
                return false;
            }

        } catch (Throwable $e) {
            report($e);
            Log::info('error updating customer');
            return false;
        }
    }

    public function render()
    {
        return view('livewire.update-customer');
    }
}
