<?php 

namespace App\Modules\Houses\Filters; 

class NameSearchFilter
{
    public $query; 

    public function __construct($query)
    {
        $this->query = $query; 
    }

    public function handle()
    {
        return $this->execute(); 
    }

    public function execute()
    {
        return $this->query
        ->when(request()->name, function ($query, $name) {
            return $query->where('name','like','%' . $name . '%');
        }); 
    }
}