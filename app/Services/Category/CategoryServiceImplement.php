<?php

namespace App\Services\Category;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryServiceImplement extends ServiceApi implements CategoryService
{

    /**
     * set title message api for CRUD
     * @param string $title
     */
    protected string $title = "";
    /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected CategoryRepository $mainRepository;

    public function __construct(CategoryRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)
    public function getData()
    {
        return $this->mainRepository->getData();
    }

    public function store($data)
    {
        $rules = [
            'ori_kw_seccond' => 'required',
        ];

        $message = [
            'name.required' => 'Nama kategori wajib disi.'
        ];

        $validator = Validator::make($data, $rules, $message);

        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        // simpan ke database
        $this->mainRepository->store($data);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil disimpan.',
        ];
    }

    public function show($id)
    {
        return $this->mainRepository->show($id);
    }

    public function update($request, $id)
    {
        $rules = [
          'name.required' => 'required'
        ];

        $message = [
            'name.required' => 'Nama kategori wajib disi.'
        ];

        $validator = Validator::make($request, $rules, $message);

        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        // Update the existing record
        $this->mainRepository->update($request, $id);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ];
    }

    public function destroy($id)
    {
        $this->mainRepository->destroy($id);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil dihapus.',
        ];
    }

    public function findByName($data)
    {
        return $this->mainRepository->findByName($data);
    }
}
