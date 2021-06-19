<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentsController extends Controller
{
    public function buttons()
    {
        return View('components.buttons');
    }
    public function grid()
    {
        return View('components.grid');
    }
}
