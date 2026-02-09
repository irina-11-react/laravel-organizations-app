<?php

namespace Database\Seeders;

//use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
        Organization::factory()->count(5)->create();
        OrganizationRelation::factory()->count(15)->create();

    }
}
