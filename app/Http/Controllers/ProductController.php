<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::latest();

            return DataTables::of($products)
                ->addIndexColumn()

                ->addColumn('image', function ($product) {
                    return '<img src="'.$product->image_url.'" width="80" class="rounded shadow-sm">';
                })

                ->addColumn('price', function ($product) {
                    return 'Rp ' . number_format($product->price, 0, ',', '.');
                })

                ->addColumn('actions', function ($product) {
                    return '
                    <form action="'.route('products.destroy', $product->id).'" method="POST">
                        '.csrf_field().method_field('DELETE').'

                        <button type="button"
                            class="btn btn-sm btn-primary-custom text-white btn-edit"
                            data-id="'.$product->id.'"
                            data-title="'.e($product->title).'"
                            data-description="'.e($product->description).'"
                            data-price="'.$product->price.'"
                            data-stock="'.$product->stock.'"
                            data-image="'.$product->image_url.'">
                            Edit
                        </button>

                        <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="confirmDelete(this)">
                            Hapus
                        </button>
                    </form>';
                })

                ->rawColumns(['image', 'actions'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        Product::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return back()->with('success', 'Product berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            $product->image = $image->hashName();
        }

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return back()->with('success', 'Product berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }

        $product->delete();

        return back()->with('success', 'Product berhasil dihapus');
    }
}