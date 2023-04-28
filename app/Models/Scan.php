<?php

namespace App\Models;

use App\Config\ConfigFileCollection;
use App\EntryPoint\EntryPointCollection;
use App\Models\Casts\SerializationCast;
use App\Models\Scopes\UserOwning;
use App\RouteParser\RouteCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property EntryPointCollection $vulnerabilities
 * @property ConfigFileCollection $credentials
 * @property ConfigFileCollection $settings
 * @property RouteCollection $entrypoints
 * @property Application $application
 * @property string $config
 */
class Scan extends Model
{
    use HasFactory;
    use UserOwning;

    protected $casts = [
        'vulnerabilities' => SerializationCast::class,
        'credentials' => SerializationCast::class,
        'settings' => SerializationCast::class,
        'entrypoints' => SerializationCast::class
    ];

    protected $fillable = [
        'vulnerabilities',
        'credentials',
        'settings',
        'entrypoints',
        'config'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
