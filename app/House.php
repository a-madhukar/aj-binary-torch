<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Houses\Filters\RunFilters;

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

    public static function search()
    {
        return RunFilters::handle(
            (new static)->latest('updated_at')
        ); 
    }
}
