<?php

namespace App\Models\Translations;

use A17\Twill\Models\Model;
use App\Models\Book;

class BookTranslation extends Model
{
    protected $baseModuleModel = Book::class;
}
