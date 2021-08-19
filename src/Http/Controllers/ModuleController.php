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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return isset($this->model::first()->translations) ? new $this->collection(
            $this->model::published()
                ->translated()
                ->translatedIn(app()->getLocale())
                ->whereHas('translations', function ($query) {
                    return $query->whereActive(true);
                })
                ->paginate()
        ) : new $this->collection($this->model::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new $this->resource($this->model::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
