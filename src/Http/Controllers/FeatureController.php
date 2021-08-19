<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Http\Request;
use A17\Twill\Models\Feature;
use A17\Twill\API\Http\Resources\FeatureCollection;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new FeatureCollection(Feature::all());
    }
}
