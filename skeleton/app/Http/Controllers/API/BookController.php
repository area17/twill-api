<?php

namespace App\Http\Controllers\API;

use A17\Twill\API\Http\Controllers\ModuleController;

class BookController extends ModuleController
{
    protected $moduleName = 'books';

    protected $model = 'App\\Models\\Book';
}
