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
 * @property ProviderType $provider_type_id
 */
class Provider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'provider_type_id'
    ];

    protected $hidden = ['id'];

    protected $with = ['providerType'];

    public function providerType()
    {
        return $this->belongsTo(ProviderType::class, 'provider_type_id');
    }

    public function discounts()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', 'LIKE', '%'. $type . '%');
    }

    public function scopeOfCorredor($query)
    {
        return $query->where('type', '=', 'Corredor');
    }

    public function scopeOfDistribuidora($query)
    {
        return $query->where('type', '=', 'Distribuidora');
    }
}
