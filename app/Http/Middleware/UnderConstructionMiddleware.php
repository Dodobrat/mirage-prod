<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UnderConstructionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return response()->view('under_construction');
    }
}
