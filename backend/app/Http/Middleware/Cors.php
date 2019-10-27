<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Class Cors
 * @package App\Http\Middleware
 */
class Cors
{
    /**
     * @param         $request
     * @param Closure $next
     *
     * @return ResponseHeaderBag
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;

//        $response = $next($request);
//        $response->headers->set('Access-Control-Allow-Origin', '*');
//        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
//        $response->headers->set('Access-Control-Allow-Headers', 'Accept, X-XSRF-TOKEN, Access-Control-Allow-Headers, X-Requested-With, Content-Type, X-Auth-Token, Authorization, Origin');
//
//        return $response;
    }
}
