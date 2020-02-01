<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
