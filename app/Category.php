<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'state'
    ];

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }
}
