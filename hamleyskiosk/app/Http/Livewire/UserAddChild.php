<?php

namespace App\Http\Livewire;

use App\Models\Child;
use Livewire\Component;
use App\Services\Herzblut\Facades\Trader;
use Illuminate\Support\Facades\Log;
use Klaviyo\Klaviyo as Klaviyo;
use Klaviyo\Model\EventModel as KlaviyoEvent;

class UserAddChild extends Component
{
    public $cart = [];
    public $count = 0;
    public $name;
    public $dob;
    public $terms;
    public $printed = false;
    public $children = [];

    public $customer_code;

    public $dob_day;
    public $dob_month;
    public $dob_year;
    //
    public $first_name;
    public $last_name;
    public $email;
    public $mobile_number;
    public $store_name;
    //
    private $klaviyo_client;
    protected $rules = [

        'name' => 'required|max:25',
        'dob' => 'required|date',
        'terms' => 'required'

    ];

    protected $fillable = [
        'name',
        'dob',
        'terms',
        'printed'
    ];

    public function mount()
    {
        $this->customer_code = $this->customer_code[0]['code'];
        $customer_details = Trader::fetchCustomer($this->customer_code);
        $this->first_name = $customer_details->first_name;
        $this->last_name = $customer_details->last_name;
        $this->email = $customer_details->email;
        $this->mobile_number = $customer_details->mobile_number;
        $this->store_name = $customer_details->store_name;
        $session_cart = session('cart');

        if ($session_cart != null) {
            $this->children = $session_cart;
        } else {
            $this->children = $this->buildChildrenArray();
        }


        // if ($request->session()->has('cart')) {
        //   $this->children = $request->session()->get('cart');
        // }else{
        //   $this->children = [];
        // }
    }

    private function buildChildrenArray() {
        return Child::where('customer_code', $this->customer_code)->get()->toArray();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {

        if (is_array($this->children) && count($this->children) >= 5) {
            $this->dispatchBrowserEvent('alert',
                ['type' => 'warning', 'message' => 'Cannot add more than 5 children']);
            return;
        }
        $validatedData = $this->validate();

        if ($validatedData) {
            $validatedData['printed'] = false;
        }


        array_push($this->children, $validatedData);
        session(['cart' => $this->children]);

        $klaviyo_children_array = [];
        foreach ($this->children as $child) {
            $klaviyo_children_array[$child['name']] = $child['dob'];
            $child['customer_code'] = $this->customer_code;
            $this->saveChildToDb($child);
        }
        //  send event to Klaviyo
        $event = new KlaviyoEvent(
            array(
                'event' => 'Printed Card at Kiosk',
                'customer_properties' => array(
                    '$email' => $this->email,
                    'Children' => $klaviyo_children_array
                ),
                'properties' => $klaviyo_children_array
            )
        );

        //
        $client = new Klaviyo(config('klaviyo.private_key'), config('klaviyo.public_key'));

        $resp = $client->publicAPI->track($event, true);

        if ($resp == "1") {
            $this->dispatchBrowserEvent('alert',
                ['type' => 'success', 'message' => 'Child added successfully']);
        }

        $this->reset('name');
        $this->reset('dob');
        $this->reset('terms');

    }

    private function saveChildToDb($child) {
        $existing = Child::where('name', $child['name'])->where('dob', $child['dob'])->where('customer_code', $child['customer_code'])->first();
        if (empty($existing)) {
            $childModel = new Child($child);
            $childModel->save();
        }
    }

    public function add()
    {

    }

    public function render()
    {
        return view('livewire.user-add-child');
    }

    public function cleanCart(): void
    {

        $this->children = [];
        session(['cart' => $this->children]);

    }
}
