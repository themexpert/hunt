<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Create a new settings controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'dev']);
    }

    /**
     * Show token settings page.
     *
     * @return \Illuminate\Http\Response
     */
    public function token()
    {
        return view('settings.token');
    }
}
