<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class customerCode extends Model
{
    use HasFactory;
    protected $table = 'customer_codes';

    protected $fillable = [
        'code',
        'store_id'
    ];

    public function reserveCode($store_id){
      $dt = Carbon::now();

      $dt->addMinutes(30);
      $this->releaseLocks($store_id);

        // release codes which reserve time has expired
        // retrieve unused client code
      $code = DB::table('customer_codes')->where("store_id" , "=", $store_id)
        ->where("state" , "=", 1)
        ->first();

        customerCode::where('id', $code->id)
        ->update(['state' => 2, 'lock_end_time' => $dt]);
        $code->lock_end_time = $dt->toDateTimeString();
        return $code;
    }

    public function lockCode($code){

     return customerCode::where('id', $code)
      ->update(['state' => 3]);
    }



    public function countCode($store_id){

      return customerCode::where('store_id', $store_id)
       ->where('state' , 1)->count();
     }

    public function releaseLocks($store_id){

      $release_locks = [];
      $dt = Carbon::now();
      $result = DB::table('customer_codes')->where("store_id" , "=", $store_id)
        ->where("state" , "=", 2)
        ->where("lock_end_time" ,'<',$dt)
        ->get();

      foreach($result as $r){
        customerCode::where('id', '=', $r->id)->update(['state' => 1, 'lock_end_time' => null]);
      }



    }
}
