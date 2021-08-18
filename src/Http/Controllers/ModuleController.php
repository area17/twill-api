<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Support\Str;
use A17\Twill\API\Http\Controllers\Controller;

class ModuleController extends Controller
{
    protected $resourcesNamespace = 'App\\Http\\Resources';

    protected $moduleName;

    protected $model;

    public function list()
    {
        $modelName = Str::ucfirst(Str::singular($this->moduleName));
        $collection = $this->resourcesNamespace.'\\'.$modelName."Collection";

        return new $collection($this->model::paginate());
    }
}
