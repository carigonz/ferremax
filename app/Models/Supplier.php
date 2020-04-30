<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'supplier_id',
        'price',
        'code'
    ];

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeOfSupplierName($query, $name){
        return !$name ? $query : $query->where('suppliers.name', 'LIKE', '%'. $name .'%');
    }

    public function scopeOfSupplierRubro($query, $rubro){
        return !$rubro ? $query : $query->where('suppliers.rubro', 'LIKE', '%'. $rubro .'%');
    }

    // public function scopeOfSupplierId($query, $id){
    //     if (is_array($id) && !empty($id)) {
    //         return $query->whereIn('products.supplier_id', $id);
    //     } else {
    //         return !$id ? $query : $query->where('products.supplier_id', $id);
    //     }
    // }

    public static function getNames(){
        $suppliers = Supplier::all();
        $suppNames = [];
        foreach ($suppliers as $supplier) {
            $suppNames[]=($supplier->factoryName);
        }
        return $suppNames;
    }

}
