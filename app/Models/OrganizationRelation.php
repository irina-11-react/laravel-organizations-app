<?php

namespace App\Models;

use Database\Factories\OrganizationRelationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationRelation extends Model
{
    /** @use HasFactory<OrganizationRelationFactory> */
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'related_organization_id',
        'type',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function related()
    {
        return $this->belongsTo(
            Organization::class,
            'related_organization_id'
        );
    }
}
