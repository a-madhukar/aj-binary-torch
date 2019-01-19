<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class HousesController extends Controller
{
    public function index()
    { 
        return House::search()->paginate(20); 
    }
}
