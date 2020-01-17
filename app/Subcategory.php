<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'state',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
