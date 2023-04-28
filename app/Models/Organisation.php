<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

/**
 *
 * @protected int $id
 * @protected string $name
 */
class Organisation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scans() : HasManyThrough
    {
        return $this->hasManyThrough(Scan::class, Application::class);
    }

    public function notificationSettings(): HasMany
    {
        return $this->hasMany(NotificationSetting::class);
    }

    public static function createWithUser($organisation, array $user): array
    {
        $organisation = new Organisation(['name' => $organisation]);
        $organisation->save();

        $created = new User($user);
        $created->password = Hash::make($user['password']);
        $created->organisation()->associate($organisation);
        $created->save();

        return [$organisation, $created];
    }
}
