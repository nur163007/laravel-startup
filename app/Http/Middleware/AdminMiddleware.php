<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AdminMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next ,$role = null)
    {
        try {
            $token_role = $this->auth->parseToken()->getClaim('role');
        }catch (JWTException $e){
            return response()->json(['error' => 'Unauthorized'],401);
        }
        if ($token_role != $role){
            return response()->json(['error' => 'Unauthorized'],401);
        }
        return $next($request);
    }
}
