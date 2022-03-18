<?php

namespace A17\Twill\API\Models;

use A17\Twill\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Mediable extends MorphPivot
{
    protected $table = 'mediables';

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getImageAttribute()
    {
        $media = $this->mediable->medias->where('id', $this->media->id)->first();

        return $this->mediable->imageAsArray($this->role, $this->crop, [], $media);
    }
}
