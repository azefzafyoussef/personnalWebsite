<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SetLocale
{
    public function handle($request, Closure $next)
{
    $locale = session('locale', config('app.locale'));

    if (! in_array($locale, ['en', 'fr', 'ar'])) {
        $locale = 'en';
    }

    app()->setLocale($locale);

    return $next($request);
}

}
