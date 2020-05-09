<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Catalog
 * 
 * @property string $name
 * @property string|null $description
 * @property boolean $taxes
 * @property Provider $provider_id
 */
class Catalog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'taxes',
        'provider_id'
    ];

    protected $hidden = ['id'];

    protected $with = ['providers'];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function discounts()
    {
        return $this->morphMany(TariffDiscount::class, 'discountable');
    }
}