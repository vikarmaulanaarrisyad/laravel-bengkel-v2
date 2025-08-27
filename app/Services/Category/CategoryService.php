<?php

namespace App\Services\Category;

use LaravelEasyRepository\BaseService;

interface CategoryService extends BaseService
{
    public function getData();
    public function store($data);
    public function show($id);
    public function update($request, $id);
    public function destroy($id);
    public function findByName($data);
}
