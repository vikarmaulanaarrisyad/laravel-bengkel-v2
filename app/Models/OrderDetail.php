<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'order_details';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // app/Models/OrderDetail.php
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
