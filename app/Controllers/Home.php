<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('Login/index');
    }
    public function register()
    {
        return view('Login/register');
    }
}