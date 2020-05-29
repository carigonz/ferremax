<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Catalog
 * 
 * @property string $name
 * @property string $acronym
 * @property string|null $description
 * @property boolean $taxes
 * @property Provider $provider
 * @property float|null $taxes_amount
 * @property string $file_name
 * @property Collection|Discount $discounts
 */
class Catalog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'acronym',
        'description',
        'taxes',
        'provider_id',
        'taxes_amount',
        'file_name'
    ];

    protected $hidden = ['id','providers'];

    protected $with = [];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function discounts()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    /** @param float $neto */
    public function getTariffWithIVA($neto)
    {
        return ($neto * ($this->taxes_amount / 100)) + $neto ;
    }

    public function scopeOfProviderId($query, $id)
    {
        return $query->where('provider_id', $id);
    }
}