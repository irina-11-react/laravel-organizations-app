<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            '*.org_name' => 'required|string',
            '*.daughters' => 'array',
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data as $orgData) {
                $this->storeOrganizationRecursive($orgData);
            }
        });

        return response()->json(['status' => 'ok']);
    }

    private function storeOrganizationRecursive(array $data, ?Organization $parent = null)
    {
        $org = Organization::firstOrCreate([
            'name' => $data['org_name']
        ]);

        if ($parent instanceof Organization) {
            OrganizationRelation::firstOrCreate([
                'organization_id' => $parent->id,
                'related_organization_id' => $org->id,
                'type' => 'child',
            ]);
        }

        foreach ($data['daughters'] ?? [] as $daughter) {
            $this->storeOrganizationRecursive($daughter, $org);
        }
    }

    public function relations(string $name, Request $request)
    {
        $perPage = min($request->get('per_page', 100), 100);
        $page = max((int) $request->get('page', 1), 1);

        $org = Organization::where('name', $name)->firstOrFail();

        // parents
        $parents = $org->parents()->get()->map(fn($o) => [
            'relationship_type' => 'parent',
            'org_name' => $o->name,
        ]);

        // daughters
        $daughters = $org->children()->get()->map(fn($o) => [
            'relationship_type' => 'daughter',
            'org_name' => $o->name,
        ]);

        // sisters
        $parentIds = $org->parents()->select('organizations.id')->pluck('id');

        $sisterIds = OrganizationRelation::whereIn('organization_id', $parentIds)
            ->where('type', 'child')
            ->where('related_organization_id', '!=', $org->id)
            ->pluck('related_organization_id');

        $sisters = Organization::whereIn('id', $sisterIds)->get()->map(fn($o) => [
            'relationship_type' => 'sister',
            'org_name' => $o->name,
        ]);

        // merge
        $all = $parents->merge($sisters)->merge($daughters)
            ->sortBy('org_name')
            ->values();

        $paginated = $all->forPage($page, $perPage);

        return response()->json([
            'data' => $paginated,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $all->count(),
            ],
        ]);
    }
}
