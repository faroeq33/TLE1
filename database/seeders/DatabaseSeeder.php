<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // Call methode maakt mogelijk dat je meerdere seeders of factories kan toevoegen
        $this->call([
            OrganisationSeeder::class,
            UserSeeder::class, // UserSeeder is dependent on OrganisationSeeder, do not change order
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
