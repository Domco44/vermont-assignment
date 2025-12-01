<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $available = array_keys(config('locales.available'));

        $locale = session('locale');

        if (!$locale || !in_array($locale, $available)) {
            $locale = config('app.locale');
            session(['locale' => $locale]);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
