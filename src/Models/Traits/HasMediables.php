<?php

namespace A17\Twill\API\Models\Traits;

use A17\Twill\API\Models\Mediable;

trait HasMediables
{
    public function mediables()
    {
        return $this->morphMany(
            Mediable::class,
            'mediable',
        );
    }
}
