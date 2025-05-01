<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $header = $request->header('Accept-Language');

        if ($header) {
            $languages = explode(',', $header);
            $preferredLanguage = $languages[0];
        } else {
            $preferredLanguage = 'en';
        }

        App::setLocale($preferredLanguage);

        return $next($request);

    }
}
