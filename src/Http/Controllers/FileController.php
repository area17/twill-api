<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Http\Request;
use A17\Twill\Models\File;
use A17\Twill\API\Http\Resources\FileCollection;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new FileCollection(File::all());
    }
}
