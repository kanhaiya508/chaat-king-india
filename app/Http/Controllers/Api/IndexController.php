<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    /**
     * Display a listing of AI services
     */
    public function index()
    {
        return response()->json([
            'message' => 'Api Working',
        ]);
    }

  
}
