<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class product 
 * 
 * @property string $code
 * @property string $name
 * @property Tariff $tariff_id
 * @property Catalog $catalog_id
 * @property Section $section_id
 * @property string $description
 * @property int $stock
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'section_id',
        'tariff_id',
        'catalog_ud',
        'description',
        'stock'
    ];

    protected $hidden = ['id'];

    protected $with = ['tariffs', 'sections'];

    public function discounts()
    {
        return $this->morphMany(TariffDiscount::class, 'discountable');
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function tariff()
    {
        return $this->hasOne(Tariff::class);
    }

    // public function scopeOfSupplierId($query, $id){
    //     if (is_array($id) && !empty($id)) {
    //         return $query->whereIn('products.supplier_id', $id);
    //     } else {
    //         return !$id ? $query : $query->where('products.supplier_id', $id);
    //     }
    // }
}

