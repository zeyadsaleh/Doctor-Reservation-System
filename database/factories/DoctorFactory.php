<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Doctor;
use Faker\Generator as Faker;

$factory->define(Doctor::class, function (Faker $faker) {
    $speciality = ['Neurology', 'Orthopedics', 'Oncology', 'Optician', 'Dermatology'];
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'speciality' => $faker->randomElement($speciality)
    ];
});
