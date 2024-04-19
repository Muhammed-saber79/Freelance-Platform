<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiCustomKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // This is a custom header for more security, it has to be sent in the request headers.
        if ($request->header('x-api-key') !== config('app.api_custom_key')) {
            return response()->json(['message' => 'Invalid API key'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
