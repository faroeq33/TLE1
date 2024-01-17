<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder {
    /**
     * Run the database seeds.
     */

    public function run(): void {
        $organisations = [
            ['name' => 'Streamteam Testorganisatie'],
            ['name' => 'Rijksmuseum'],
            ['name' => 'Van Gogh Museum'],
            ['name' => 'Openluchtmuseum'],
            ['name' => 'Local Tours Holland'],
            ['name' => 'Stadhuismuseum Zierikzee'],
            ['name' => 'Streekmuseum De Meestoof'],
            ['name' => 'Mesdag Museum'],
            ['name' => 'Kunstmuseum Den Haag'],
            ['name' => 'Marine Museum'],
            ['name' => 'Gilde Utrecht '],
            ['name' => 'Slot Loevestein'],
            ['name' => 'Nederlands Openluchtmuseum']
        ];

        $datedOrganisations = array_map(function ($organisation) {
            $organisation['created_at'] = Carbon::now();
            $organisation['updated_at'] = Carbon::now();
            return $organisation;
        }, $organisations);

        // prevents the seeder from creating new organistations if one already exists. purpose checks only 1 name for performance
        if (Organisation::where('name', 'Streamteam Testorganisatietest')->exists()) {
            return;
        }
        // Insert organisations into the database
        Organisation::insert($datedOrganisations);
    }
}
