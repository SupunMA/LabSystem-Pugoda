<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AvailableTest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'horizon',
            'email' => 'horizonpugoda@gmail.com',
            'nic' => '123456789v',
            'password' => Hash::make('12345678'),
	        'role' => 1
        ]);

        // $this->call([
        //     UserSeeder::class,
        //     PatientSeeder::class,
        // ]);

    }
}
