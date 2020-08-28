<?php

namespace App\Http\Middleware;

use App\Models\Responsible; 
use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role )
    {
       $responsible = Auth::user();
        
       if("Owner"== $role && $responsible->role==Responsible::ROLE_OWNER){
            return $next($request);
        }
        
        abort(403);
    }
}
