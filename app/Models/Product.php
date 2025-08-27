<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews()
{
    return $this->hasMany(\App\Models\Review::class);
}

}
