<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        $apiKey = $request->header('X-API-KEY');
        
        if (!$apiKey) {
            return response()->json([
                'error' => 'API key is required',
                'message' => 'X-API-KEY header is missing'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        // Validate API key format and check against allowed keys
        $validApiKeys = config('app.api_keys', []);
        
        if (!in_array($apiKey, $validApiKeys)) {
            return response()->json([
                'error' => 'Invalid API key',
                'message' => 'The provided API key is not valid'
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        return $next($request);
    }
} 