<?php

namespace App\Services\Order;

use LaravelEasyRepository\BaseService;

interface OrderService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($request, $id);
    public function destroy($id);
}
