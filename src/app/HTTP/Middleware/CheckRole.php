<?php

namespace processdrive\rap\Middleware;

use Closure;

class CheckRole
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
         if (\Auth::user()->hasPermission($request->route()->getName()))
         return $next($request);
         else
         return response(
              view('error.noaccess', [
                      "message" => trans("error.access_denied"), 
                      "descripetion" => trans("error.ad_descripetion")
                  ]
              )
          );
    }   
}
