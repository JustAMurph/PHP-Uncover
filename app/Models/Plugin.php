<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Plugin extends Model
{
    use HasFactory;

    public $guarded = [];

    public static function findByName($name)
    {
        return (new static())->newQuery()->where('name', $name)->firstOrFail();
    }
}
