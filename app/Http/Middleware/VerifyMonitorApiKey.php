<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyMonitorApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $provided = $request->header('X-Monitor-Key');
        $expected = config('monitor.api_key');

        // if (! $provided || ! hash_equals($expected, $provided)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        return $next($request);
    }
}