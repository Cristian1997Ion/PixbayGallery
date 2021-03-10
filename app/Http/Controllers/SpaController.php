<?php

namespace App\Http\Controllers;

/**
 * Class SpaController
 * @package App\Http\Controllers
 */
class SpaController extends Controller
{
    public function index(): string
    {
        return view('spa');
    }
}
