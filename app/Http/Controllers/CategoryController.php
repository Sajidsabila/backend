<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::paginate(10);
        if ($categories->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data Category Kosong',
                'data' => []
            ], 201);

        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data BEbrhasil Ditemukan',
                'data' => $categories
            ], 200);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute tersebut sudah digunakan.'
        ], [
            'name' => 'Kategori '
        ]);
        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $data->errors()
            ], 422);
        }
        try {
            $category = Category::create([
                'name' => $request->name
            ]);
            return response([
                'success' => true,
                'message' => 'Category berhasil disimpan',
                'data' => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan : ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id
        ], [
            'required' => ':attribute wajib diisi.',
            'unique' => ':attribute tersebut sudah digunakan.'
        ], [
            'name' => 'Kategori '
        ]);
        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $data->errors()
            ], 422);
        }
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category tidak ditemukan'
                ], 404);
            }

            $category->update([
                'name' => $request->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category berhasil diubah',
                'data' => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan : ' . $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response([
                    'success' => false,
                    'message' => 'Category tidak ditemukan'
                ], 404);
            }
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category berhasil dihapus',
                'data' => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan : ' . $th->getMessage()
            ], 500);
        }
    }
}
