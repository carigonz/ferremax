<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    use SoftDeletes;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public static function getNames(){
        $suppliers = Supplier::all();
        $suppNames = [];
        foreach ($suppliers as $supplier) {
            $suppNames[]=($supplier->factoryName);
        }
        return $suppNames;
    }

}
