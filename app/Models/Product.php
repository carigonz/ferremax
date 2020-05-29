<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * Class product 
 * 
 * @property string $code
 * @property string $provider_code
 * @property string $name
 * @property float $price
 * @property float|null $public_price
 * @property bool|false $custom
 * @property Catalog $catalog
 * @property Section|null $section_id
 * @property string|null $description
 * @property int|null $stock
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'provider_code',
        'name',
        'price',
        'public_price',
        'custom',
        'section_id',
        'catalog_id',
        'description',
        'stock'
    ];

    protected $hidden = ['id','tariffs', 'sections', 'catalog'];

    protected $with = [];

    public function discounts()
    {
        return $this->morphMany(Discount::class, 'discountable');
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function Section()
    {
        return $this->belongsTo(Section::class);
    }

    // public function scopeOfSupplierId($query, $id){
    //     if (is_array($id) && !empty($id)) {
    //         return $query->whereIn('products.supplier_id', $id);
    //     } else {
    //         return !$id ? $query : $query->where('products.supplier_id', $id);
    //     }
    // }
}

