<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return response()->view('index');
    }
}
