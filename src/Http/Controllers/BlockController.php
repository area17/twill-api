<?php

namespace A17\Twill\API\Http\Controllers;

use A17\Twill\API\Http\Resources\BlockResource;
use A17\Twill\API\Http\Resources\BlockCollection;
use A17\Twill\Models\Block;
use A17\Twill\API\Http\Controllers\Controller;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BlockCollection(Block::paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BlockResource(Block::findOrFail($id));
    }
}
