<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $handcrafts = Product::where('category', 'handcraft')->orderBy('name')->get();
        $imported   = Product::where('category', 'imported')->orderBy('name')->get();

        return view('admin.products.index', compact('handcrafts', 'imported'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category'     => ['required', 'in:' . implode(',', array_keys(Product::CATEGORIES))],
            'description'  => ['nullable', 'string'],
            'price'        => ['required', 'numeric', 'min:0'],
            'cost_price'   => ['required', 'numeric', 'min:0'],
            'initial_sold' => ['nullable', 'integer', 'min:0'],
            'images'       => ['nullable', 'array', 'max:8'],
            'images.*'     => ['mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data['slug']         = $this->uniqueSlug($data['name']);
        $data['initial_sold'] = $data['initial_sold'] ?? 0;
        $data['in_stock']     = $request->boolean('in_stock');
        unset($data['images']);

        $product = Product::create($data);

        foreach ($request->file('images', []) as $i => $file) {
            $product->images()->create([
                'path'       => $this->saveImage($file),
                'sort_order' => $i,
            ]);
        }

        return redirect()->route('admin.products.index')->with('status', 'Product added.');
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'item';
        $slug = $base;
        $i = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function saveImage(UploadedFile $file): string
    {
        $name = Str::random(20) . '.' . $file->extension();
        $file->move(public_path('images/products'), $name);

        return 'images/products/' . $name;
    }
}