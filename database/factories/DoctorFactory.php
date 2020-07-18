<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Doctor;
use Faker\Generator as Faker;

$factory->define(Doctor::class, function (Faker $faker) {
    $specialty = ['Neurology','Orthopedics','Oncology','Optician','Dermatology'];
    return [
        'email' => $faker->unique()->safeEmail,
        'specialty'=>$faker->randomElement($specialty)
    ];
});