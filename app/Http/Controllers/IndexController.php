<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{


    public function index()
    {
        return view('website.index');
    }

    public function about()
    {
        return view('website.about');
    }

    public function contact()
    {
        return view('website.contact');
    }

    public function menu()
    {
        return view('website.menu');
    }

    public function gallery()
    {
        return view('website.gallery');
    }

    public function service()
    {
        return view('website.service');
    }

}
