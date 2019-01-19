<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;

class HousesController extends Controller
{
    public function index()
    {
        $query = House::latest('updated_at')
        ->when(request()->name, function ($query, $name) {
            return $query->where('name','like','%' . $name . '%');
        })
        ->when(request()->address, function ($query, $address) {
            return $query->where(function ($query) use ($address) {
                $query->where('address_1', 'like', '%' . $address.'%')
                ->orWhere('address_1', 'like', '%' . $address . '%')
                ->orWhere('city', 'like', '%' . $address . '%') 
                ->orWhere('state', 'like', '%' . $address . '%') 
                ->orWhere('country', 'like', '%' . $address . '%') 
                ->orWhere('postal_code', 'like', '%' . $address . '%'); 
            });             
        }); 

        $equals = collect([
            'quality' => 'house_quality', 
            'contract_type' => 'contract_type', 
            'country' => 'country'
        ])->filter(function ($column, $parameter) {
            return !is_null(request($parameter)); 
        })->each(function ($column, $parameter) use (&$query) {
            $query->where($column, request($parameter)); 
        }); 

        $range = collect([
            'price_max' => 'price|price_min', 
            'duration_max' => 'rental_duration|duration_min', 
            'rating_max' => 'rating|rating_min'
        ])->filter(function ($column, $parameter) {
            return !is_null(request($parameter)); 
        })->each(function ($arguments, $parameter) use (&$query) {
            [$column, $minParameter] = explode('|',$arguments); 

            $query->whereBetween($column, [
                request($minParameter) ?: 0, 
                request($parameter)
            ]); 
        }); 

        return response()->json([
            'data' => $query->get()
        ], 200); 
    }
}
