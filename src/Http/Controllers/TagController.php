<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Http\Request;
use A17\Twill\Models\Tag;
use A17\Twill\API\Http\Resources\TagCollection;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TagCollection(Tag::all());
    }
}
