<?php

namespace App\Services\Product;

use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($request, $id);
    public function destroy($id);
}
