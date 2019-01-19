<?php 

namespace App\Modules\Houses\Filters; 

class RunFilters 
{
    public $query; 

    public function __construct($query)
    {
        $this->query = $query; 
    }

    public static function handle($query)
    {
        return (new static($query))->execute(); 
    }

    public function execute()
    {
        $filters = collect([
            GenericFilters::class, 
            AddressFilter::class, 
            NameSearchFilter::class, 
        ])
        ->each(function ($class) {
            (new $class($this->query))->handle(); 
        }); 

        return $this->query; 
    }
}