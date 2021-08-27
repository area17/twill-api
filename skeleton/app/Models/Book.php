<?php

namespace App\Models;

use App\Models\Author;
use A17\Twill\Models\Model;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasFactory, HasTranslation;

    protected $fillable = [
        'published',
        'title',
        'description',
        'isbn',
        'publication_date',
        'formats',
        'topics',
        'forthcoming',
        'available',
    ];

    public $translatedAttributes = [
        'title',
        'description',
        'active',
        'subtitle',
        'summary',
    ];

    public $slugAttributes = [
        'title',
    ];

    protected $casts = [
        'formats' => 'array',
        'topics' => 'array',
        'available' => 'array',
    ];

    public $filesParams = [
        'attachment',
        'attachments',
    ];

    public $mediasParams = [
        'cover' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
            'flexible' => [
                [
                    'name' => 'free',
                    'ratio' => 0,
                ],
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
                [
                    'name' => 'portrait',
                    'ratio' => 3 / 5,
                ],
            ],
        ],
        'preview' => [
            'default' => [
                [
                    'name' => 'default',
                ],
            ],
        ],
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class)->orderBy('position');
    }

    public function getFormatsAttribute($value)
    {
        return collect(json_decode($value))->map(function ($value) {
            return [
                'id' => $value,
            ];
        })->all();
    }

    public function setFormatsAttribute($value)
    {
        $this->attributes['formats'] = collect($value)->filter()->values();
    }

    public function getTopicsAttribute($value)
    {
        return collect(json_decode($value))->map(function ($value) {
            return [
                'id' => $value,
            ];
        })->all();
    }

    public function setTopicsAttribute($value)
    {
        $this->attributes['topics'] = collect($value)->filter()->values();
    }

    public function getAvailableAttribute($value)
    {
        return collect(json_decode($value))->first();
    }

    public function setAvailableAttribute($value)
    {
        $this->attributes['available'] = collect($value)->filter()->values();
    }
}
