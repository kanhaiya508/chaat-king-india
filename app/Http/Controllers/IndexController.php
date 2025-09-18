<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class IndexController extends Controller
{


    public function index()
    {
        $categories = Category::with(['items.variants', 'items.addons'])->take(5)->get();
        return view('website.index', compact('categories'));
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
        $categories = Category::with(['items.variants', 'items.addons'])->get();
        return view('website.menu', compact('categories'));
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
