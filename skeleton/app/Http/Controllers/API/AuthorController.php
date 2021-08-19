<?php

namespace App\Http\Controllers\API;

use App\Models\Author;
use A17\Twill\API\Http\Controllers\ModuleController;

class AuthorController extends ModuleController
{
    protected $moduleName = 'authors';

    protected $model = Author::class;
}
