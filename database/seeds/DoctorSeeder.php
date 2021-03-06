<?php

use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Doctor::class, 15)->create()->each(function ($doctor) {
            $doctor->user()->save(factory(App\User::class)->create()->assignRole('doctor'));
        });
    }
}
