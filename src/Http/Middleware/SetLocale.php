<?php

namespace A17\Twill\API\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->input('locale');

        if (!$locale) {
            $locale = config('app.locale');
        }

        if (array_search($locale, config('translatable.locales')) === false) {
            return abort(403, 'Language not supported.');
        }

        app()->setLocale($locale);

        $response = $next($request);

        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
