<?php

namespace App\Http\Controllers;

//import model product
use App\Models\Product;
//import return type View
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(): View
    {
        //render view with products
        return view('products.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::latest();

            return DataTables::of($products)
                ->addIndexColumn()

                ->addColumn('image', function ($product) {
                    if ($product->image) {
                        return '<img src="' . asset('storage/products/' . $product->image) . '"
                width="80"
                class="rounded shadow-sm">';
                    }
                    return '-';
                })

                ->addColumn('price', function ($product) {
                    return "Rp " . number_format($product->price, 2, ',', '.');
                })

                ->addColumn('actions', function ($product) {
                    return '
                    <form action="' . route('products.destroy', $product->id) . '" method="POST">
                        ' . csrf_field() . method_field('DELETE') . '

                        <button type="button"
                            class="btn btn-sm btn-primary-custom text-white btn-edit"
                            data-id="' . $product->id . '"
                            data-title="' . e($product->title) . '"
                            data-description="' . e($product->description) . '"
                            data-price="' . $product->price . '"
                            data-stock="' . $product->stock . '"
                            data-image="' . asset('storage/products/' . $product->image) . '">
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
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

        return redirect()->back()->with('success', 'Product berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/products/' . $product->image);

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

        return redirect()->back()->with('success', 'Product berhasil diupdate');
    }

    public function destroy($id)
    {
        // cari product
        $product = Product::findOrFail($id);

        // hapus gambar dari storage
        Storage::delete('public/products/' . $product->image);

        // hapus data dari database
        $product->delete();

        return redirect()->back()->with('success', 'Product berhasil dihapus');
    }
}
