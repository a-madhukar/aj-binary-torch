<?php

namespace Tests\Unit;

use App\House;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HouseUnitTest extends TestCase
{
    /**
     * @test
     */
    public function the_price_should_be_converted_into_an_integer_when_saving_to_the_db()
    {
        $house = factory(House::class)->create([
            'price' => 1000, 
        ]); 

        $this->assertDatabaseHas('houses',[
            'id' => $house->id, 
            'name' => $house->name, 
            'price' => 1000 * 100, 
        ]);
    }

    /**
     * @test
     */
    public function the_price_should_be_converted_back_into_original_value_when_reading_from_db()
    {
        $house = factory(House::class)->create([
            'price' => 1000, 
        ]); 

        $this->assertEquals(1000, House::find($house->id)->price); 
    }
}
