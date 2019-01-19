<?php

use App\House;
use Faker\Generator as Faker;

$factory->define(House::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3), 
        'address_1' => $faker->streetAddress, 
        'address_2' => $faker->secondaryAddress, 
        'city' => $faker->city, 
        'state' => $faker->state, 
        'country' => $faker->country, 
        'postal_code' => $faker->postcode, 
        'rental_duration' => $faker->numberBetween(1,24), 
        'contract_type' => array_rand(array_flip(['short','mid','long'])), 
        'rating' => $faker->numberBetween(1,5), 
        'house_quality' => array_rand(array_flip(['bad','good','great'])),
        'price' => $faker->numberBetween(10000, 100000), 
        'status' => rand(0,1)
    ];
});
