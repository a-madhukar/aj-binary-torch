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
        $this->houses(); 

        $response = $this->get('houses')->assertStatus(200); 

        $this->assertCount(20, $response->decodeResponseJson()['data']); 
    }

    /**
     * @test
     */
    public function a_user_can_search_for_the_houses_by_the_name()
    {
        $this->houses(); 

        factory(House::class)->create([
            'name' => 'the fresh prince mansion'
        ]); 

        $response = $this->json('GET','houses',['name' => 'the fresh prince mansion']); 
        
        $this->assertCount(1, $response->decodeResponseJson()['data']);

        $this->assertEquals('the fresh prince mansion', $response->decodeResponseJson()['data'][0]['name']);      
    }

    /**
     * @test
     */
    public function a_user_can_filter_the_houses_by_the_house_quality()
    {
        $this->houses(); 
        
        $response = $this->json('GET','houses',['quality' => 'great']); 

        $this->assertCount(
            count($response->decodeResponseJson()['data']), 
            collect($response->decodeResponseJson()['data'])->filter(function ($house) {
                return $house['house_quality'] == 'great'; 
            })
        ); 
    }

    public function houses()
    {
        return factory(House::class, 20)->create(); 
    }
}
