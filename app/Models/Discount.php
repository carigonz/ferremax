<?php

namespace App\Models;

use App\Models\Provider;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class discount
 * 
 * @property int $discountable_id
 * @property Model $discountable_type
 * @property float $amount
 * @property boolean $active
 */
class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'discountable_id',
        'discountable_type',
        'amount',
        'active'
    ];

    protected $hidden = ['id'];

    protected $with = [];

    public function discountable()
    {
        return $this->morphTo();
    }

}