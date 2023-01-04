<?php

namespace A17\Twill\API\Http\Middleware;

use A17\Twill\API\Models\Scopes\RelatedItemPublishedScope;
use A17\Twill\Models\RelatedItem;
use Closure;
use Illuminate\Http\Request;

class EnableRelatedItemPublishedScope
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
        RelatedItem::addGlobalScope(new RelatedItemPublishedScope());

        return $next($request);
    }
}
