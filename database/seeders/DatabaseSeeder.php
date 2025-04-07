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
        // User::create([
        //     'name' => 'Anuththara',
        //     'email' => 'admin@a.com',
        //     'password' => Hash::make('12345678'),
	    //     'role' => 1
        // ]);

        $this->call([
            UserSeeder::class,
            PatientSeeder::class,
        ]);

        // AvailableTest::create([
        //     'AvailableTestName' => 'Fasting Blood Sugar',
        //     'AvailableTestRange' => '70-120',
        //     'AvailableTestCost' => 1100,
        // ]);

        // AvailableTest::create([
        //     'AvailableTestName' => 'Full Blood Count',
        //     'AvailableTestRange' => '80-180',
        //     'AvailableTestCost' => 1000,
        // ]);

        // AvailableTest::create([
        //     'AvailableTestName' => 'Lipid Profile',
        //     'AvailableTestRange' => '80-180',
        //     'AvailableTestCost' => 1200,
        // ]);

        // AvailableTest::create([
        //     'AvailableTestName' => 'Microalbumin (Urine)',
        //     'AvailableTestRange' => '80-180',
        //     'AvailableTestCost' => 1200,
        // ]);

        // AvailableTest::create([
        //     'AvailableTestName' => 'Urea & Electrolytes',
        //     'AvailableTestRange' => '80-180',
        //     'AvailableTestCost' => 800,
        // ]);
    }
}
