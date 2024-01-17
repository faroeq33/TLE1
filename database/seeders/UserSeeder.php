<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */

    private function getOrganisationId($name) {
        return Organisation::where('name', $name)->first()->id;
    }

    private function nameExists($name) {
        return User::where('name', $name)->exists();
    }

    private function createTestUser() {
        $organisationId = $this->getOrganisationId('Streamteam Testorganisatie');

        // This prevents the seeder from creating a new user if one already exists
        if ($this->nameExists('testuser')) {
            return;
        }

        User::create([
            'organisation_id' => $organisationId, // Verwijst naar streamteam testorganisatie
            'name' => 'testuser',
            'is_admin' => 0,
            'password' => Hash::make('testpassword123'),
            'email' => 'test@test.com',
        ]);
    }

    private function createTestAdminUser() {
        $organisationId = $this->getOrganisationId('Streamteam Testorganisatie');
        // This prevents the seeder from creating a new user if one already exists
        if ($this->nameExists('testadmin')) {
            return;
        }

        User::create([
            'organisation_id' => $organisationId, // Verwijst naar streamteam testorganisatie
            'name' => 'testadmin',
            'is_admin' => 1,
            'password' => Hash::make('testpassword123'),
            'email' => 'testadmin@test.com',
        ]);
    }

    public function run(): void {
        // testgegevens voor de gids
        $this->createTestUser();

        // testgegevens voor de admin
        $this->createTestAdminUser();
    }
}
