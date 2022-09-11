<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HandoverModel;

class Handover extends BaseController
{
    public function index()
    {
        $modelHandover = new HandoverModel();

        return view('Handover/index', ['data' => $modelHandover->findAll()]);
    }
}