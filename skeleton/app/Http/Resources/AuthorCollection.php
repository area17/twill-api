<?php

namespace App\Http\Resources;

use A17\Twill\API\Http\Resources\ModuleCollection;

class AuthorCollection extends ModuleCollection
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
