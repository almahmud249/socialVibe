<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        $prefix     = '';

        $url        = URL::current();

        $baseprefix = str_replace(URL::to('/'), '', $url);

        if (isset(explode('/', $baseprefix)[1])) {
            $prefix = explode('/', $baseprefix)[1];
            if (setting('default_language') == $prefix) {
                return redirect()->to(str_replace('/'.setting('default_language'), '', $url));
            }
        }

        return $next($request);
    }
}
