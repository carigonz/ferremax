<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Create new provider view
     */
    public function create()
    {
        return view('providers.create');
    }
}
