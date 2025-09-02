<?php

namespace App\Http\Controllers;

use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        $result = $this->categoryService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('action', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->categoryService->store($request->all());

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
        $result = $this->categoryService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->categoryService->update($request->all(), $id);

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
        $result = $this->categoryService->destroy($id);

        return response()->json([
            'message' => $result['message'],
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->input('name');

        $result = $this->categoryService->findByName($q);

        return response()->json($result);
    }

    /**
     * Render aksi buttons
     */
    protected function renderActionButtons($q)
    {
        $aksi = '';
        if (Auth::user()->hasPermissionTo('Category Show') || Auth::user()->hasPermissionTo('Category Edit')) {
            $aksi .= '
                <button onclick="editForm(`' . route('category.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
            ';
        }

        if (Auth::user()->hasPermissionTo('Category Delete')) {
            $aksi .= '
                <button onclick="deleteData(`' . route('category.destroy', $q->id) . '`, `' . $q->name . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
            ';
        }
        return $aksi;
    }
}
