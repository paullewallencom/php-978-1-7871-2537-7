<?php
namespace App\Http\Middleware;
use Closure;
use Auth;

class AuthToken
{
    public function handle($request, Closure $next)
    {
        if(Auth::attempt($request->all())){
            return $next($request);
        }else{
            echo "no logea";
        }

        echo "fin";EXIT;
    }
}