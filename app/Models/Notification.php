<?php

namespace App\Models;

use App\Models\Scopes\UserOwning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $message
 * @property boolean $read
 */
class Notification extends Model
{
    use HasFactory;
    use UserOwning;

    protected $fillable = ['message', 'read'];
}
