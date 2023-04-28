<?php

namespace App\Models;

use App\Models\Scopes\OrganisationOwning;
use App\Models\Scopes\UserOwning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $evaluation
 * @property string $email
 */
class NotificationSetting extends Model
{
    use HasFactory, OrganisationOwning;

    protected $fillable = ['evaluation', 'email'];
}
