<?php 

namespace App\Modules\Houses\Filters; 

class AddressFilter 
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
    }
}