<?php

namespace App\Models\Scopes;

use App\Models\Organisation;
use App\Models\User;

/**
 * @property int $organisation_id
 */
trait OrganisationOwning
{
    public function scopeOrganisationOwned($query, Organisation $organisation)
    {
        return $query->where('organisation_id', $organisation->id);
    }

    public function scopeOrganisationOwnedById($query, $organisationId)
    {
        return $query->where('organisation_id', $organisationId);
    }

    public function isOwnedByOrganisation(Organisation $organisation)
    {
        return $this->organisation_id === $organisation->id;
    }

}
