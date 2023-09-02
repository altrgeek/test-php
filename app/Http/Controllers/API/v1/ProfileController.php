<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Helpers\JSON;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Return JSON response for this API endpoint
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return JSON::success($request->user());
    }
}
