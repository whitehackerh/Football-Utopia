<?php
namespace App\Http\Middleware;

use Closure;

class AfterBackEnd {
    public function handle($request, Closure $next) {
        $response = $next($request);
        return $response;
    }
}