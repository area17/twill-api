<?php

namespace A17\Twill\API\Models;

use A17\Twill\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Mediable extends MorphPivot
{
    protected $table = 'twill_mediables';

    protected $with = ['media', 'mediable'];

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
        /**
         * Need to provide the related media with the pivot information to imageAsArray()
         */
        $role = $this->role;
        $crop = $this->crop;
        $media = $this
            ->mediable
            ->medias
            ->where('id', $this->media->id)
            ->first(
                function ($media) use ($role, $crop) {
                    return $media->pivot->role === $role && $media->pivot->crop === $crop;
                }
            );

        return $this->mediable->imageAsArray($role, $crop, [], $media);
    }

    public function getTable()
    {
        return config('twill.mediables_table', 'twill_mediables');
    }
}
