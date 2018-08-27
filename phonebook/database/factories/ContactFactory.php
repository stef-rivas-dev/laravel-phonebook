<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(9),
        'phone_number' => $faker->e164PhoneNumber,
        'label' => $faker->name,
        'email' => $faker->email,
    ];
});
