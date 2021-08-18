<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use A17\Twill\API\Http\Controllers\Controller;

class ModuleController extends Controller
{
    protected $resourcesNamespace = 'App\\Http\\Resources';

    protected $moduleName;

    protected $model;

    protected $modelName;

    protected $collection;


    public function __construct()
    {
        $this->modelName = Str::ucfirst(Str::singular($this->moduleName));
        $this->collection = $this->resourcesNamespace.'\\'.$this->modelName."Collection";
        $this->resource = $this->resourcesNamespace.'\\'.$this->modelName."Resource";
    }

    public function list()
    {
        return new $this->collection(
            $this->model::published()
                ->whereHas(
                    'translations',
                    function (Builder $query) {
                        return $query
                            ->whereActive(true)
                            ->whereLocale(app()->getLocale());
                    }
                )
                ->paginate()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return new $this->resource($this->model::findOrFail($id));
    }
}
