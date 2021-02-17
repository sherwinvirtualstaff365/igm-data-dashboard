<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Sherwin de Jesus',
            'email' => 'sherwin@virtualstaff365.com.au',
            'password' => Hash::make('password'),
        ]);

        User::factory(20)->create();
    }
}
