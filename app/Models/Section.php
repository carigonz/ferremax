<?php

namespace App\Models;

use App\Models\Category;
use App\Models\TariffDiscount;
use App\Models\Classification;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Section 
 * 
 * @property string $name
 * @property string|null $description
 * @property Collection $products
 * @property Category $category_id
 */
class Section extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = ['id','products', 'category'];

    protected $with = [];

    public function discounts()
    {
        return $this->morphMany(TariffDiscount::class, 'discountable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
