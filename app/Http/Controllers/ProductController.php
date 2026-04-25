<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $search = $request->input('search');

        $query = Product::query();

        if ($search) {
            $query->where('nama_produk', 'like', '%' . $search . '%');
        }

        $products = $query->orderBy($sort, $direction)->paginate(5);
        return view('products.index', compact('products', 'sort', 'direction'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:products,nama_produk',
            'deskripsi_produk' => 'nullable|string|max:1000',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
        ],[
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'nama_produk.unique' => 'Nama produk sudah ada, gunakan nama yang berbeda.',
            'deskripsi_produk.max' => 'Deskripsi maksimal 1000 karakter.',
            'harga_produk.required' => 'Harga wajib diisi.',
            'harga_produk.numeric' => 'Harga harus berupa angka.',
            'harga_produk.min' => 'Harga tidak boleh kurang dari 0.',
            'stok_produk.required' => 'Stok wajib diisi.',
            'stok_produk.integer' => 'Stok harus bilangan positif.',
            'stok_produk.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        Product::create($request->all());

        return redirect()
            ->route('products.index')
            ->with('success','Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.read', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:products,nama_produk,' . $product->id,
            'deskripsi_produk' => 'nullable|string|max:1000',
            'harga_produk' => 'required|numeric|min:0',
            'stok_produk' => 'required|integer|min:0',
        ],[
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'nama_produk.unique' => 'Nama produk sudah ada, gunakan nama yang berbeda.',
            'deskripsi_produk.max' => 'Deskripsi maksimal 1000 karakter.',
            'harga_produk.required' => 'Harga wajib diisi.',
            'harga_produk.numeric' => 'Harga harus berupa angka.',
            'harga_produk.min' => 'Harga tidak boleh kurang dari 0.',
            'stok_produk.required' => 'Stok wajib diisi.',
            'stok_produk.integer' => 'Stok harus bilangan positif.',
            'stok_produk.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        $product->update($request->all());

        return redirect()
            ->route('products.index')
            ->with('success','Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success','Produk berhasil dihapus.');
    }

    public function export()
    {
        $products = \App\Models\Product::all();

        $filename = "products.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Nama', 'Deskripsi','Harga', 'Stok', 'Dibuat', 'Diperbarui']);

            foreach ($products as $p) {
                fputcsv($file, [
                    $p->id,
                    $p->nama_produk,
                    $p->deskripsi_produk,
                    $p->harga_produk,
                    $p->stok_produk,
                    $p->created_at,
                    $p->updated_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
