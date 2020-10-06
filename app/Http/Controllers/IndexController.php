<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class IndexController extends Controller
{
  /**
   * @return \Illuminate\Http\RedirectResponse
   */
    public function index(): \Illuminate\Http\RedirectResponse
    {
//      return Redirect::route('dashboard');
    }
}
