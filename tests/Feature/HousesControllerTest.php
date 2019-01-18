<?php

namespace Tests\Feature;

use App\House; 
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HousesControllerTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * @test
     */
    public function a_user_can_list_all_the_houses_on_the_site()
    {
        $houses = factory(House::class, 20)->create(); 

        $this->get('houses')
        ->assertStatus(200); 
    }
}
