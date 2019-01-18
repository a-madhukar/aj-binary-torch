<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class HousesController extends Controller
{
    public function index()
    {
        $houses = House::latest('updated_at')->get(); 

        return response()->json([
            'data' => $houses
        ], 200); 
    }
}
