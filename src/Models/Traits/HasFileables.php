<?php

namespace A17\Twill\API\Models\Traits;

use A17\Twill\API\Models\Fileable;

trait HasFileables
{
    public function fileables()
    {
        return $this->morphMany(
            Fileable::class,
            'fileable',
        );
    }
}
