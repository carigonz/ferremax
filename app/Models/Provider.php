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
 * @property ProviderType $providerType
 * @property Provider|null $parent
 * @property boolean $status
 */
class Provider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'provider_type_id',
        'parent_id',
        'status'
    ];

    protected $hidden = ['id'];

    protected $with = ['providerType'];

    public function providerType()
    {
        return $this->belongsTo(ProviderType::class, 'provider_type_id');
    }

    public function parent()
    {
        return $this->belongsTo(Provider::class, 'parent_id');
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

    public function isDistribuidoraType()
    {
        return $this->providerType() ? $this->providerType->isDistribuidora() : false;
    }
}
