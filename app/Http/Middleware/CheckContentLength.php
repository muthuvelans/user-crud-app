<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * CheckContentLength
 *
 * This Middleware handles checking body content length for user json data
 *
 * @category   Checking Body Content Length
 * @package    App\Http\Middleware
 * @author     Muthu velan
 * @created    01-03-2025
 * @updated    01-03-2025
 */

class CheckContentLength
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //Added this if condition for Checking body content length limit
        if (strlen($request->getContent()) > 500) {
            return response()->json(['message' => 'Payload too large'], 413);
        }
        return $next($request);
    }
}
