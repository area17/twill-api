<?php

namespace App\Http\Resources;

use App\Http\Resources\AuthorCollection;
use A17\Twill\API\Http\Resources\ModuleResource;

class BookResource extends ModuleResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'authors' => new AuthorCollection($this->authors),
        ];
    }
}
