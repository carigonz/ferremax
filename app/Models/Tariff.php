<?php

namespace App\Models;

use App\Models\Product;
use App\Models\TariffDiscount;
use Illuminate\Database\Eloquent\Model;

/**
 * Class tariff 
 * 
 * @property Product $product_id
 * @property decimal $amount
 * @property Collection $discounts
 */
class Tariff extends Model
{
    protected $fillable = [
        'amount',
        'product_id'
    ];

    protected $hidden = ['id'];

    protected $with = [];

    public function discounts()
    {
        return $this->morphMany(TariffDiscount::class, 'discountable');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}