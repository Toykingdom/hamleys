<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Herzblut\Facades\Trader;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\customerCode;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
class CustomerController extends Controller
{
    public $layout = 'layouts.app';
    public $result;
    //
    public function addChild(Request $request){

    }


    public function updateCustomer(Request $request, $customer_number){
        return view('customer.updateCustomer', compact('customer_number'));
    }

    public function addChildren(Request $request, $customer_code){
        // dd('this is not cool');
        // get customer details from remote endpoint
        $user = Auth::user();

        if (!$user->is_admin) {

            $customer_codem = new customerCode();
            $user_store = DB::table('user_stores')->where('user_id', $user->id)->first();
            $remaining_codes_count = $customer_codem->countCode($user_store->id);

            if ((int)env('CODES_NOTIFICATION_REMAINING_COUNT', '') >= (int)$remaining_codes_count) {

                Session::flash('message', 'Low customer codes remaining: ' . $remaining_codes_count);
                Session::flash('alert-class', 'alert-danger');
            }
        }
        $user_details = [array( 'code'=> $customer_code)];

        return view('customer.addChildren',compact('user_details'));
    }

    public function printCard(Request $request, $customer_code, $name) {

        return view('layouts.print', ["code" => $customer_code, "name" => $name]);
    }


}
