<?php

namespace App\Models;

use App\Models\ProviderType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Provider
 * 
 * @property string $name
 * @property string|null $description
 * @property string|null $phone
 * @property ProviderType $provider_type
 */
class Provider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'provider_type'
    ];

    protected $hidden = ['id'];

    protected $with = ['provider_types'];

    public function providerType()
    {
        return $this->belongsTo(ProviderType::class, 'provider_type');
    }

    public function discounts()
    {
        return $this->morphMany(TariffDiscount::class, 'discountable');
    }
}
