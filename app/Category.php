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
    // public function tag()
    // {
    //     return $this->belongsTo(Catalogue::class);
    // }
}
