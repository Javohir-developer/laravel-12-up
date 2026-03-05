<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['uz', 'ru', 'en'];
        $defaultLocale = 'uz';

        if (session()->has('locale') && in_array(session('locale'), $supportedLocales)) {
            app()->setLocale(session('locale'));
        } else {
            // Avtomatik brauzer tilini olish
            $browserLanguage = $request->getPreferredLanguage($supportedLocales);
            $locale = $browserLanguage ? $browserLanguage : $defaultLocale;
            
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
