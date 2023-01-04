<?php

namespace A17\Twill\API\Http\Middleware;

use A17\Twill\API\Models\Scopes\FeaturePublishedScope;
use A17\Twill\Models\Feature;
use Closure;
use Illuminate\Http\Request;

class EnableFeaturePublishedScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Feature::addGlobalScope(new FeaturePublishedScope());

        return $next($request);
    }
}
