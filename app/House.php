<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100; 
    }

    protected function getPriceAttribute($value)
    {
        if (is_null($value)) {
            return 0; 
        }

        return $value/100; 
    }
}
