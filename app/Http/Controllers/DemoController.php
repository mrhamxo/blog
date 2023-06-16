<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function homeMain(){
        return view('frontend.index');
    }

    public function about(){
        return view('about');
    }
    public function contact(){
        return view('contact');
    }
}
