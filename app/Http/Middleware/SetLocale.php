<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
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
        $locale = $request->session()->get('locale', $request->cookie('locale', config('app.locale', 'ar')));

        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }

        App::setLocale($locale);

        View::share('current_locale', $locale);
        View::share('direction', $locale === 'ar' ? 'rtl' : 'ltr');

        return $next($request);
    }
}

