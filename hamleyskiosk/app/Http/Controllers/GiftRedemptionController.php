<?php

namespace App\Http\Controllers;

use App\Models\GiftRedemption;
use App\Services\Herzblut\Facades\Trader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GiftRedemptionController extends Controller
{
    public $layout = 'layouts.app';

    public function redeem(Request $request, $customer_code="")
    {
        $user = auth()->user();
        return view('gifts/redeem',["customer_code" => $customer_code, "user" => $user] );
    }

    public function report(Request $request, $month=null) {

        $user = auth()->user();
        if ($user->is_admin) {
            $report = $this->buildReport(intval(($month !== null) ? $month : $request->query('month', 0)));
            return $this->outputReport($report);
        }

        return ['response' => 'ok'];
    }

    private function buildReport($month=0) {
        $keys = [
            "account_code",
            "child_name",
            "child_dob",
            "parent_first_name",
            "surname",
            "email",
            "mobile",
            "promo_title",
            "promo_type",
            "store_redeemed",
            "date_redeemed"
        ];
        $start_date = Carbon::now();
        if ($month > 0) {
            $start_date = $start_date->subMonths($month);
        }
        $dates = [$start_date->startOfMonth()->toDateTimeString(), $start_date->endOfMonth()->toDateTimeString()];
        $redemptions = GiftRedemption::whereBetween('created_at', $dates)->get();
        $customers = [];
        $rows = [];

        foreach($redemptions as $redemption) {
            $custKey = $redemption->child->customer_code;
            if (!isset($customers[$custKey])) {
                $customers[$custKey] = Trader::fetchCustomer($custKey);
            };

            $customer = $customers[$custKey];
            $store = $redemption->user->stores()->first();

            $rows[] = [$custKey,
                $redemption->child->name,
                $redemption->child->dob,
                (!empty($customer))? $customer->first_name : 'Unknown',
                (!empty($customer))? $customer->last_name : 'Unknown',
                (!empty($customer))? $customer->email : 'Unknown',
                (!empty($customer))? $customer->mobile_number : 'Unknown',
                $redemption->gift->name,
                $redemption->gift->type,
                $store->name,
                $redemption->created_at,
            ];

        }

        return ["keys" => $keys, "rows" => $rows];
    }

    private function outputReport($report) {
        $callback = function() use($report) {
            $f = fopen('php://output', 'w');
            fputcsv($f, $report['keys']);
            foreach ($report['rows'] as $row) {
                fputcsv($f, $row);
            }
            fclose($f);
        };

        $filename = 'hamleys-redemption-report-' . date('YmdHis') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        return response()->stream($callback, 200, $headers);
    }
}
