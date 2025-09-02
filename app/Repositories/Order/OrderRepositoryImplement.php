<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderRepositoryImplement extends Eloquent implements OrderRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Order $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with(['user', 'orderDetail'])->orderBy('created_at', 'DESC')->get();
    }

    public function store($data)
    {
        return $this->model->create($data);
    }
    public function show($id)
    {
        $orderDetails = OrderDetail::with('product')->where('order_id', $id)->get();

        $orderDetails->each(function ($orderDetail) {
            $orderDetail->price = format_uang($orderDetail->price);
            $orderDetail->subtotal = format_uang($orderDetail->subtotal);
        });

        // Return the modified order details
        return $orderDetails;
    }
}
