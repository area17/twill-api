<?php

namespace App\Models;

use App\Models\Book;
use A17\Twill\Models\Model;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model implements Sortable
{
    use HasSlug, HasMedias, HasPosition, HasFactory;

    protected $fillable = [
        'published',
        'title',
        'biography',
        'position',
        'content'
    ];

    public $slugAttributes = [
        'title',
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
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
