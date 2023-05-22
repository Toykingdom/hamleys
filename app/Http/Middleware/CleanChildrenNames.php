<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;

class CleanChildrenNames
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
          if ( $request->user() ){
            $request->session()->forget('cart');

            if (!$request->is('customer/print-cards/*')) {
              if ($request->session()->exists('cart')) {
                  $request->session()->forget('cart');
              }
            }
        } else {
          if (!$request->is('login')) {
           return redirect('/login');
        }
      }

      return $next($request);
    }
}
