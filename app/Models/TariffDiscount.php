<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class tariff discount
 * 
 * @property int $discountable_id
 * @property Model $discountable_type
 * @property decimal $amount
 * @property Provider $provider_id
 */
class TariffDiscount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'discountable_id',
        'discountable_type',
        'amount'
    ];

    protected $hidden = ['id'];

    protected $with = [];

    public function discountable()
    {
        return $this->morphTo();
    }

}