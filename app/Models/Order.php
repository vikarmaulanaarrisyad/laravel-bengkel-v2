<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public function orderDetail1()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'Success':
                $color = 'success';
                break;
            case 'Pending':
                $color = 'warning';
                break;
            case 'cancel':
                $color = 'danger';
                break;
            default:
                break;
        }

        return $color;
    }
}
