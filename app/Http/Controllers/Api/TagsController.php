<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Tag;
use Hunt\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * Create a new instance of tags controller.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'emailActivation']);
    }

    /**
     * Get all tags.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return Tag::all();
    }
}