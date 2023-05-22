<?php

namespace App\Http\Livewire;

use App\Models\Child;
use App\Models\Gift;
use App\Models\GiftRedemption;
use Carbon\Carbon;
use Livewire\Component;
use App\Services\Herzblut\Facades\Trader;
use Illuminate\Support\Facades\Log;
use Klaviyo\Klaviyo as Klaviyo;
use Klaviyo\Model\EventModel as KlaviyoEvent;

class RedeemGifts extends Component
{
    public $count = 0;
    public $children = [];
    public $user;
    public $customer;
    public $customer_code;
    public $gifts;
    public $redeemed = [];
    public $alreadyRedeemed = [];
    public $dates = [];
    private $redeemedCache = [];

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

        $this->dates = [Carbon::now()->startOfMonth()->toDateTimeString(), Carbon::now()->endOfMonth()->toDateTimeString()];
        $this->customer = collect(Trader::fetchCustomer($this->customer_code))->toArray();
        $this->gifts = Gift::get()->toArray();
        $this->children = $this->buildChildrenArray();
        $this->redeemed = $this->alreadyRedeemed = $this->buildRedeemedArray();
    }

    private function buildChildrenArray() {
        $children = Child::where('customer_code', $this->customer_code)->get()->toArray();
        foreach($children as $index => $child) {
            foreach($this->gifts as $gindex => $gift) {
                $children[$index]["gifts"][$gindex] = $gift;
                $children[$index]["gifts"][$gindex]["key"] = implode("|", [$child['id'], $gift['id']]);
            }
        }

        return $children;
    }

    private function buildRedeemedArray(){
        $redeemed = [];
        $children = Child::where('customer_code', $this->customer_code)->get();
        foreach ($children as $child) {
            foreach ($child->redemptions()->whereBetween('created_at', $this->dates)->get() as $redemption) {
                $redeemed[] = implode('|', [$child['id'], $redemption['gift_id']]);
            }
        }

        return $redeemed;
    }

    public function submit()
    {

        foreach($this->redeemed as $redeem) {

            if (!$this->isAlreadyRedeemed($redeem)) {
               $items = $this->extractChildAndGift($redeem);
                $redeemModel = new GiftRedemption([
                    "user_id" => $this->user['id'],
                    "gift_id" => $items['gift']['id'],
                    "child_id" => $items['child']['id'],
                    "cost" => $items['gift']['cost']
                ]);
                $redeemModel->save();
                $this->redeemedCache[$redeem] = true;
            }
        }

        foreach($this->alreadyRedeemed as $toRemove) {
            if (!in_array($toRemove, $this->redeemed)) {
                $items = $this->extractChildAndGift($toRemove);
                GiftRedemption::whereBetween('created_at', $this->dates)->where('gift_id', $items['gift']['id'])->where('child_id', $items['child']['id'])->delete();
            }
        }

        $this->dispatchBrowserEvent('alert',
            ['type' => 'success', 'message' => 'Gift redemptions processed successfully']);

    }

    private function extractChildAndGift($id) {
        $keys = explode("|", $id);
        return [ "gift" => $this->getGiftById($keys[1]), "child" => $this->getChildById($keys[0])];
    }

    public function getGiftById($id) {
        foreach($this->gifts as $gift) {
            if (intval($gift['id']) === intval($id)) {
                return $gift;
            }
        }

        return null;
    }

    public function getChildById($id) {
        foreach($this->children as $child) {
            if (intval($child['id']) === intval($id)) {
                return $child;
            }
        }
        return null;
    }

    public function isAlreadyRedeemed($id) {
        if (isset($this->redeemedCache[$id])) {
            return $this->redeemedCache[$id];
        }

        $items = $this->extractChildAndGift($id);
        $redemption = GiftRedemption::whereBetween('created_at', $this->dates)->where('gift_id', $items['gift']['id'])->where('child_id', $items['child']['id'])->first();
        $this->redeemedCache[$id] = !empty($redemption);

        return $this->redeemedCache[$id];

    }

    public function render()
    {
        return view('livewire.redeem-gifts');
    }
}
