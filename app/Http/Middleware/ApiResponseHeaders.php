<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->noContent(204)->withHeaders($this->headers());
        }

        $response = $next($request);

        return $response->withHeaders($this->headers());
    }

    private function headers(): array
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With, Accept',
        ];
    }
}
