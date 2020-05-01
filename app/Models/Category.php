<?php

namespace App\Models;

use App\Models\Section;
use App\Models\TariffDiscount;
use App\Models\Classification;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classification 
 * 
 * @property string $name
 * @property string|null $description
 * @property Collection $sections
 * @property Classification $classification_id
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = ['id'];

    protected $with = ['sections', 'classification'];

    public function discounts()
    {
        return $this->morphMany(TariffDiscount::class, 'discountable');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}