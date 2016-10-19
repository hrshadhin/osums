<?php

namespace App\Http\Middleware;

use Closure;

class Account
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->group !="Account" && $request->user()->group !="Admin"){
          $notification= array('title' => 'Access Denied!', 'body' => 'You do not have permission to do that!');
          return redirect()->route('user.dashboard')->with('error',$notification);
        }
        return $next($request);
    }
}
