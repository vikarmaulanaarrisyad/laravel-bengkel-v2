<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.index');
    }

    public function data()
    {
        $result = $this->productService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('price', fn($q) => $this->renderPrice($q))
            ->editColumn('path_image', fn($q) => $this->renderPathImage($q))
            ->editColumn('action', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->productService->store($request->all());

        if ($result['status'] === 'success') {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors'  => $result['errors'],
            'message' => $result['message'],
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = $this->productService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->productService->update($request->all(), $id);

        if ($result['status'] === 'success') {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors'  => $result['errors'],
            'message' => $result['message'],
        ], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->productService->destroy($id);

        return response()->json([
            'message' => $result['message'],
        ]);
    }

    /**
     * Render price
     */
    protected function renderPrice($q)
    {
        return format_uang($q->price);
    }

    /**
     * Render aksi buttons
     */
    protected function renderActionButtons($q)
    {
        $aksi = '';
        if (Auth::user()->hasPermissionTo('Product Show') || Auth::user()->hasPermissionTo('Product Edit')) {
            $aksi .= '
                <button onclick="editForm(`' . route('products.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
            ';
        }

        if (Auth::user()->hasPermissionTo('Product Delete')) {
            $aksi .= '
                <button onclick="deleteData(`' . route('products.destroy', $q->id) . '`, `' . $q->name . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
            ';
        }
        return $aksi;
    }

    /**
     * Render path image
     */
    protected function renderPathImage($q)
    {
        if (!empty($q->path_image)) {
            return '<img src="' . Storage::url($q->path_image) . '" alt="Image" class="img-thumbnail" style="width: 75px; height: 75px;">';
        }
        return '<span class="text-muted">No Image</span>';
    }
}
