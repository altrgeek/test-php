<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Helpers\JSON;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return JSON response for this API endpoint
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return JSON::success('The endpoint API is working flawlessly');
    }
}
