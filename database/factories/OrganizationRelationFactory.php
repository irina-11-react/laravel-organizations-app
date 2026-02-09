<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\OrganizationRelation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrganizationRelation>
 */
class OrganizationRelationFactory extends Factory
{
    protected $model = OrganizationRelation::class;

    public function definition()
    {
        $org = Organization::inRandomOrder()->first();
        $related = Organization::inRandomOrder()->first();

        // не допускаем self-relation
        while ($org->id === $related->id) {
            $related = Organization::inRandomOrder()->first();
        }

        return [
            'organization_id' => $org->id,
            'related_organization_id' => $related->id,
            'type' => $this->faker->randomElement(['parent', 'child']),
        ];
    }
}
