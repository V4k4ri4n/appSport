<?php

namespace App\Http\Controllers;

use App\Models\Pays;

class MainController extends Controller
{
    public function index(){
        $pays = Pays::all();
        return view('welcome',compact('pays'));
    }
}
