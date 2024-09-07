<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{

    public function handle(Request $request, Closure $next): Response
    {

        $locale = $request->has('lang') ? $request->get('lang') : config('app.locale');

        if (in_array($locale, config('app.available_locales'))) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
