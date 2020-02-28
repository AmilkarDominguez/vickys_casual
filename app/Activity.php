<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'state',
        'user_id',
        'barcode',
        'store',
        'product',
        'category',
        'subcategory',
        'price',
        'discount',
        'price_discount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
