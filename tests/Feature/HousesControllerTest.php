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

    /**
     * @test
     */
    public function a_user_can_filter_the_houses_by_the_contract_type()
    {
        $this->houses();        

        $response = $this->json('GET','houses',['contract_type' => 'long']); 

        $this->assertCount(
            count($response->decodeResponseJson()['data']), 
            collect($response->decodeResponseJson()['data'])->filter(function ($house) {
                return $house['contract_type'] == 'long'; 
            })
        );
    }

    /**
     * @test
     */
    public function a_user_can_filter_the_houses_by_the_country()
    {
        $this->houses();        

        factory(House::class, 20)->create([
            'country' => 'Malaysia'
        ]);

        $response = $this->json('GET','houses',['country' => 'Malaysia']); 

        $this->assertCount(
            count($response->decodeResponseJson()['data']), 
            collect($response->decodeResponseJson()['data'])->filter(function ($house) {
                return $house['country'] == 'Malaysia'; 
            })
        );
    }

    /**
     * @test
     */
    public function a_user_can_filter_the_houses_by_the_price()
    {
        $this->houses();        

        factory(House::class)->create([
            'price' => 500
        ]);

        $response = $this->json('GET','houses',['price_max' => 500 * 100]); 

        $this->assertCount(1, $response->decodeResponseJson()['data']);
    }

    /**
     * @test
     */
    public function a_user_can_filter_the_houses_by_the_duration()
    {
        $this->houses();        

        factory(House::class)->create([
            'rental_duration' => 15
        ]);

        $response = $this->json('GET','houses',['duration_max' => 15]); 

        $this->assertCount(
            count($response->decodeResponseJson()['data']), 
            collect($response->decodeResponseJson()['data'])->filter(function ($house) {
                return $house['rental_duration'] <= 15; 
            })
        );
    }

    /**
     * @test
     */
    public function a_user_can_filter_the_houses_by_the_rating()
    {
        $this->houses();        

        factory(House::class)->create([
            'rating' => 2
        ]);

        $response = $this->json('GET','houses',['rating_max' => 3]); 

        $this->assertCount(
            count($response->decodeResponseJson()['data']), 
            collect($response->decodeResponseJson()['data'])->filter(function ($house) {
                return $house['rating'] <= 3; 
            })
        );
    }

    /**
     * @test
     */
    public function a_user_can_search_the_houses_by_the_address()
    {
        $this->houses();        

        factory(House::class)->create([
            'address_1' => 'Palmville resort condo'
        ]);

        $response = $this->json('GET','houses',['address' => 'Palmville resort condo']); 

        $this->assertCount(1, $response->decodeResponseJson()['data']);
    }

    public function houses()
    {
        return factory(House::class, 20)->create(); 
    }
}
