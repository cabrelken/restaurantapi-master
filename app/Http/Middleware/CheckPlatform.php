<?php

namespace App\Http\Middleware;

use Closure;
use PeterPetrus\Auth\PassportToken;
use Illuminate\Support\Facades\DB;

class CheckPlatform
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $platform = "web")
    {
        $decoded_token = PassportToken::dirtyDecode($request->header('Authorization'));
    
        if (!$decoded_token['valid']) {
            abort(403);
        }
        
        $token = DB::table('oauth_access_tokens')
        ->where('id', '=',$decoded_token['token_id'])
        ->select('name')->get();
        
        if(($token->count() == 0)||
            ($platform == "web" && $token->get(0)->name != "web")|| 
            ($platform == "mobile" && $token->get(0)->name == "web")
        ){
            abort(404);
        }

        if($platform == "web" && $token->get(0)->name == "web"){
            return $next($request);    
        }

        $tableIdToken = (int)$token->get(0)->name;
        $tableId = $request->route('tableId');
        // $request->request->add(['somme' => $tableIdToken + $tableId]);
        if($tableIdToken != $tableId){
            abort(403);
        }
        
        return $next($request);
    }
}
