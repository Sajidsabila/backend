<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('name') && $request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('status_stock') && $request->status_stock) {
            $query->where('status_stock', $request->status_stock);
        }

        if ($request->has('created_at') && $request->created_at) {
            $query->whereDate('created_at', $request->created_at);
        }



        $products = $query->paginate(10);
        // foreach ($products as $product) {
        //     number_format($product, 2);
        // }
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk ditemukan',
            'data' => $products
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status_stock' => 'required',
        ], [
            'required' => ':attribute wajib diisi.',
            'numeric' => ':attribute harus berupa angka.',
            'exists' => ':attribute tidak valid.',

        ], [
            'name' => 'Kategori',
            'price' => 'Harga',
            'description' => 'Deskripsi Product',
            'category_id' => 'Kategori',
            'status_stock' => 'Status Ketersediaan'

        ]);
        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $data->errors()
            ], 422);
        }
        try {
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'status_stock' => $request->status_stock
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Product berhasil disimpan',
                'data' => $product
            ], 200);
        } catch (\Throwable $th) {
            return response([
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
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'status_stock' => 'nullable',
        ], [
            'numeric' => ':attribute harus berupa angka.',
            'exists' => ':attribute tidak valid.',

        ], [
            'name' => 'Kategori',
            'price' => 'Harga',
            'description' => 'Deskripsi Product',
            'category_id' => 'Kategori',
            'status_stock' => 'Status Ketersediaan'

        ]);
        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $data->errors()
            ], 422);
        }
        try {

            $product = Product::find($id);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product tidak ditemukan'
                ], 404);
            }
            $product->update(array_filter([
                'name' => $request->input('name', $product->name),
                'price' => $request->input('price', $product->price),
                'description' => $request->input('description', $product->description),
                'category_id' => $request->input('category_id', $product->category_id),
                'status_stock' => $request->input('status_stock', $product->status_stock),
            ]));
            return response([
                'success' => true,
                'message' => 'Product berhasil diubah',
                'data' => $product
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
    public function destroy(string $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response([
                    'success' => false,
                    'message' => 'Product tidak ditemukan'
                ], 404);
            }
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product berhasil dihapus',
                'data' => $product
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi Kesalahan : ' . $th->getMessage()
            ], 500);
        }
    }
}
