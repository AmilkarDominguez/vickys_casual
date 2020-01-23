<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'state',
        'name',
        'barcode',
        'price',
        'discount',
        'price_discount',
        'store_id',
        'subcategory_id'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
