<?php

namespace App\Http\Middleware;

use Closure;
// COnfiguración de aplicación
use Illuminate\Support\Facades\App;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

        if(!in_array($locale, ['en', 'es'])){
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
