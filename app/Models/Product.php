<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    use SoftDeletes;
    protected $guarded = [];
    
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopeOfSupplierId($query, $id){
        if (is_array($id) && !empty($id)) {
            return $query->whereIn('products.supplier_id', $id);
        } else {
            return !$id ? $query : $query->where('products.supplier_id', $id);
        }
    }
}

