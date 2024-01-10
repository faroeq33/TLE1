<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */


    public function run(): void {
        // testgegevens voor de gids
        User::create([
            'organisation_id' => 1, // Verwijst naar streamteam testorganisatie
            'name' => 'testuser',
            'is_admin' => 0,
            'password' => Hash::make('testpassword123'),
            'email' => 'test@test.com',
        ]);

        // testgegevens voor de admin
        User::create([
            'organisation_id' => 1, // Verwijst naar streamteam testorganisatie
            'name' => 'testadmin',
            'is_admin' => 1,
            'password' => Hash::make('testpassword123'),
            'email' => 'testadmin@test.com',
        ]);
    }
}
