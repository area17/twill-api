<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Http\Request;
use A17\Twill\Models\Media;
use A17\Twill\API\Http\Resources\MediaCollection;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MediaCollection(Media::all());
    }
}
