<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\View;

class principalController extends Controller
{
    public function principal(){
        return view('page.principal');
    }
}