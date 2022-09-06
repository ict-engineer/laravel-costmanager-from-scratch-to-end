<?php
namespace App\Http\Middleware;

use Closure;

class Subscribed {
    public function handle($request, Closure $next) {
        if ($request->user() and ! $request->user()->subscribed('default'))
            return redirect()->route('setpurchase'); 
        return $next($request);
    }
}