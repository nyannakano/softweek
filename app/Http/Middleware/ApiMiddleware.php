<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     *
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientId = $request->header('X-Client-Id');
        $clientSecret = $request->header('X-Client-Secret');

        $expectedId = config('services.client.id');
        $expectedSecret = config('services.client.secret');

        if ($clientId !== $expectedId || $clientSecret !== $expectedSecret) {
            return response()->json([
                'message' => 'Unauthorized. Invalid client credentials.'
            ], 401);
        }

        return $next($request);
    }
}
