<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'id' => 0,
            'username' => 'superadmin',
            'password' => Hash::make('123456789')
        ]);

        $admin->assignRole('super-admin');
    }
}
