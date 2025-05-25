<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDesktop
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isMobile($request)) {
            abort(403, 'Acceso solo permitido desde computadoras.');
        }
        return $next($request);
    }

    private function isMobile($request)
    {
        $userAgent = $request->header('User-Agent');
        return preg_match('/mobile|android|iphone|ipad|tablet|phone|ipod|blackberry|opera mini|opera mobi/i', $userAgent);
    }
}
