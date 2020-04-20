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

  public function new(): Response
  {
    return response()->view('dashboard.index');
  }
}
