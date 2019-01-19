<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class HousesController extends Controller
{
    public function index()
    {
        $houses = House::latest('updated_at')
        ->when(request()->name, function ($query, $name) {
            return $query->where('name','like','%' . $name . '%');
        })
        ->when(request()->quality, function ($query, $quality) {
            return $query->whereHouseQuality($quality); 
        }); 

        return response()->json([
            'data' => $houses->get()
        ], 200); 
    }
}
