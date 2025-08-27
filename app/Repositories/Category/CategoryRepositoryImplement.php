<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->all();
    }

    public function store($data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->model->create($data);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        $query = $this->model->find($id);

        if (isset($request['name'])) {
            $request['slug'] = Str::slug($request['name']);
        }

        return $query->update($request);
    }

    public function destroy($id)
    {
        $query = $this->model->find($id);
        return $query->delete();
    }

    public function findByName($data)
    {
        return $this->model->where('name', 'like', '%' . $data . '%')->get();
    }
}
