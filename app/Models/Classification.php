<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classification 
 * 
 * @property string $type
 * @property Collection $categories
 */
class Classification extends Model
{
    protected $fillable = [
        'type'
    ];

    protected $hidden = ['id', 'categories'];

    protected $with = [];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
