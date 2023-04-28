<?php

namespace App\Models;

use App\Models\Scopes\OrganisationOwning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property User $user
 * @property Plugin $plugin
 * @property Scan[] $scans
 * @property Organisation $organisation
 */
class Application extends Model
{
    use HasFactory, OrganisationOwning;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scans()
    {
        return $this->hasMany(Scan::class)->orderBy('id', 'desc');
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public static function findById($id)
    {
        return (new static)->newQuery()->where('id', $id)->firstOrFail();
    }
}
