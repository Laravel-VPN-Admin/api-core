<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InstallerController extends Controller
{
    /**
     * Show welcome message
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome(): Response
    {
        return response()->view('installer.welcome');
    }

    /**
     * Check requirements of system
     *
     * @return \Illuminate\Http\Response
     */
    public function requirements(): Response
    {
        return response()->view('installer.requirements');
    }

    /**
     * Setup database and execute migrations process
     *
     * @return \Illuminate\Http\Response
     */
    public function database(): Response
    {
        return response()->view('installer.database');
    }

    /**
     * Create administrator account
     *
     * @return \Illuminate\Http\Response
     */
    public function administrator(): Response
    {
        return response()->view('installer.administrator');
    }

    /**
     * Display finish message
     *
     * @return \Illuminate\Http\Response
     */
    public function finish(): Response
    {
        return response()->view('installer.finish');
    }
}
