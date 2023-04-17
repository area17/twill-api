<?php

namespace A17\Twill\API\Models;

use A17\Twill\Models\File;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Fileable extends MorphPivot
{
    protected $table = 'twill_fileables';

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getTable()
    {
        return config('twill.fileables_table', 'twill_fileables');
    }
}
