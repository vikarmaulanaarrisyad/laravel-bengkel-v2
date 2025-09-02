<?php

namespace App\Repositories\Order;

use LaravelEasyRepository\Repository;

interface OrderRepository extends Repository
{
    public function getData();
    public function show($id);
}
