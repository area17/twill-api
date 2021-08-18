<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use A17\Twill\API\Http\Controllers\ModuleController;

class BookController extends ModuleController
{
    protected $moduleName = 'books';

    protected $model = Book::class;
}
