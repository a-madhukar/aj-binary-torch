<?php 

namespace App\Modules\Houses\Filters; 

class GenericFilters 
{
    public $query; 

    protected $filters = [
        'quality' => 'equals|house_quality|', 
        'contract_type' => 'equals|contract_type|', 
        'country' => 'equals|country|',
        'price_max' => 'between|price|price_min', 
        'duration_max' => 'between|rental_duration|duration_min', 
        'rating_max' => 'between|rating|rating_min'
    ]; 

    public function __construct($query)
    {
        $this->query = $query; 
        $this->filters = collect($this->filters); 
    }

    public function handle()
    {
        return $this->execute(); 
    }

    public function execute()
    {
        $this->filters
        ->filter(function ($arguments, $parameter) {
            return !is_null(request($parameter)); 
        })->each(function ($arguments, $parameter) {
            [$type, $column, $minParameter] = explode('|', $arguments);
            
            $method = collect([
                'equals' => 'queryEquals', 
                'between' => 'queryBetween'
            ])->get($type);
            
            $this->{$method}($column, $parameter, $minParameter); 
        });
        
        return $this->query; 
    }

    protected function queryEquals($column, $parameter)
    {
        $this->query->where($column, request($parameter)); 
    }

    protected function queryBetween($column, $parameter, $minParameter)
    {
        $this->query->whereBetween($column, [
            request($minParameter) ?: 0, 
            request($parameter)
        ]); 
    }
}