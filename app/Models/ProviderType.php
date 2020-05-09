<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProviderType
 * 
 * @property string $type
 * @property string $description
 * @property Providers $providers
 */
class ProviderType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'description'
    ];

    protected $guarded = [];

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
}
