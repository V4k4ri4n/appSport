<?php

namespace App\Http\Controllers;

use App\Models\Ligue;
use App\Models\Pays;

class MainController extends Controller
{
    public function index(){
        $ligue = Ligue::all();
        return view('welcome',compact('ligue'));
    }
}
