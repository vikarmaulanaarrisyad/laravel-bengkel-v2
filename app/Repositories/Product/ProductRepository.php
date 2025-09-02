<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($request, $id);
    public function destroy($id);
}
