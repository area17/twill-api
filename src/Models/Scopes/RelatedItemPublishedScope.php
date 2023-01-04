<?php

namespace A17\Twill\API\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class RelatedItemPublishedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('related', function ($query) {
            $query->when(
                Schema::hasColumn($query->getModel()->getTable(), 'published'),
                function ($query) {
                    $query->where('published', true);
                }
            );
        });
    }
}
