<?php

use App\PainType;
use Illuminate\Database\Seeder;

class PainTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('type'=>'Brain', 'speciality'=>'Neurology'),
            array('type'=>'Muscles', 'speciality'=>'Orthopedics'),
            array('type'=>'Numbness', 'speciality'=>'Oncology'),
            array('type'=>'Eye', 'speciality'=>'Optician'),
            array('type'=>'Skin', 'speciality'=>'Dermatology'),

        );
        PainType::insert($data);
    }
}
