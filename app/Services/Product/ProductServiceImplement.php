<?php

namespace App\Services\Product;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Validator;

class ProductServiceImplement extends ServiceApi implements ProductService
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
    protected ProductRepository $mainRepository;

    public function __construct(ProductRepository $mainRepository)
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
            'name' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'price' => 'required|regex:/^[0-9.]+$/',
            'path_image' => 'nullable|mimes:png,jpg,jpeg',
        ];

        $message = [
            'name.required' => 'Nama produk wajib disi.',
            'stock.required' => 'Stock wajib disi.',
            'category_id.required' => 'Kategori wajib disi.',
            'price.required' => 'Harga wajib disi.',
            'path_image.required' => 'Gambar harus berextensi png,jpg,jpeg.',
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
            'name' => 'required'
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
}
