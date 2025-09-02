<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with(['category'])->get();
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $data['price'] = $this->sanitizePrice($data['price']);
            $data['slug'] = Str::slug($data['name']);

            $product = $this->model->create($data);

            if (!empty($data['path_image'])) {
                $product->path_image = $this->uploadFile($data['path_image'], 'upload/products');
                $product->save();
            }

            DB::commit();
            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function show($id)
    {
        $product = $this->model->with(['category'])->find($id);
        $product['price'] = format_uang($product['price']);

        return $product;
    }

    public function update($data, $id)
    {
        DB::beginTransaction();

        try {
            // Temukan produk berdasarkan ID
            $product = $this->model->findOrFail($id);

            // Perbarui detail produk
            if (isset($data['name'])) {
                $data['price'] = $this->sanitizePrice($data['price']);
                $data['slug'] = Str::slug($data['name']);
            }

            // Menangani upload gambar jika ada file
            if (isset($data['path_image'])) {
                // Hapus gambar lama jika ada
                $this->deleteFileIfExists($product->path_image);
                // Unggah gambar baru dan simpan produk
                $data['path_image'] = $this->uploadFile($data['path_image'], 'upload/products/');
            }
            // Perbarui data produk
            $product->update($data);

            // Komit transaksi
            DB::commit();
            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = $this->model->findOrFail($id);

            $this->deleteFileIfExists($product->path_image);
            $product->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function sanitizePrice($price)
    {
        return str_replace('.', '', $price);
    }

    private function uploadFile(UploadedFile $file, string $path): string
    {
        $filename = uniqid() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }

    private function deleteFileIfExists(string $filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
