<?php

namespace App\Http\Resources;

use A17\Twill\API\Http\Resources\ModuleResource;

class AuthorResource extends ModuleResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->title,
        ];
    }
}
