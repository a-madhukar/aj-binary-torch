<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class HousesController extends Controller
{
    public function index()
    { 
        return response()->json([
            'data' => House::search()->get()
        ], 200); 
    }
}
