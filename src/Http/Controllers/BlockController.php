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
    public function list()
    {
        return new BlockCollection(Block::paginate());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $block)
    {
        return new BlockResource(Block::findOrFail($block));
    }
}
