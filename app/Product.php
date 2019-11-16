<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = array(
        'password',
        'remember_token',
        'deleted_at',
        'created_at',
        'updated_at'
    );
    
    public function suppliers()
    {
        return $this->belongsTo('App\Supplier');
    }

    
}

