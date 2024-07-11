<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function view(){
        return view('cruds.json');
}
}
