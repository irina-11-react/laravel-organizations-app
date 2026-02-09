<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationRelation;
use Illuminate\Database\Seeder;

class OrganizationRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orgs = Organization::all();

        if ($orgs->count() < 2) {
            return;
        }

        OrganizationRelation::factory(10)->create();
    }
}
