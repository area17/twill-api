<?php

namespace A17\Twill\API\Http\Controllers;

use Illuminate\Http\Request;
use A17\Twill\Models\User;
use A17\Twill\API\Http\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new UserCollection(User::all());
    }
}
