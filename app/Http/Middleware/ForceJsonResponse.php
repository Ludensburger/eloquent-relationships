<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Ensure the request is treated as JSON
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        // Ensure the response is JSON
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
