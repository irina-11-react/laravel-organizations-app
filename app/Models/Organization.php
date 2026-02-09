<?php

namespace App\Models;

use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory;
    protected $fillable = ['name'];

    public function parents()
    {
        return $this->belongsToMany(
            Organization::class,
            'organization_relations',
            'related_organization_id',
            'organization_id'
        )->wherePivot('type', 'child');
    }

    public function children()
    {
        return $this->belongsToMany(
            Organization::class,
            'organization_relations',
            'organization_id',
            'related_organization_id'
        )->wherePivot('type', 'child');
    }
}
