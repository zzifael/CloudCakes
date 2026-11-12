<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '\%' .$request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id',$request->category_id);
        }

        if ($request->filled('sort')) {
            $query->orderBy('price',$request->sort == 'price_asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(5)->withQueryString();$categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data =$request->only(['category_id', 'name', 'price', 'stock', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] =$request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Roti baru beserta foto berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk roti berhasil dihapus!');
    }
}