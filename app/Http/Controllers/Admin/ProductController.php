<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private const MAX_PHOTOS = 8;

    public function index()
    {
        $handcrafts = Product::with('images')->where('category', 'handcraft')->orderBy('name')->get();
        $imported   = Product::with('images')->where('category', 'imported')->orderBy('name')->get();

        return view('admin.products.index', compact('handcrafts', 'imported'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

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

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        $newFiles = $request->file('images', []);

        if ($product->images()->count() + count($newFiles) > self::MAX_PHOTOS) {
            return back()
                ->withErrors(['images' => 'A product can have at most ' . self::MAX_PHOTOS . ' photos.'])
                ->withInput();
        }

        $data['initial_sold'] = $data['initial_sold'] ?? 0;
        $data['in_stock']     = $request->boolean('in_stock');
        unset($data['images']);

        // The slug (the product's web address) stays the same, so shared links keep working.
        $product->update($data);

        $next = ($product->images()->max('sort_order') ?? -1) + 1;

        foreach ($newFiles as $file) {
            $product->images()->create([
                'path'       => $this->saveImage($file),
                'sort_order' => $next++,
            ]);
        }

        return redirect()->route('admin.products.index')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            File::delete(public_path($image->path));
        }

        $product->delete(); // its photo rows are removed automatically

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    public function toggleStock(Product $product)
    {
        $product->update(['in_stock' => ! $product->in_stock]);

        return back()->with('status', $product->name . ' is now ' . ($product->in_stock ? 'in stock.' : 'out of stock.'));
    }

    public function makeCover(ProductImage $image)
    {
        $image->update(['sort_order' => 0]);

        $others = $image->product->images()->where('id', '!=', $image->id)->get();

        foreach ($others as $i => $other) {
            $other->update(['sort_order' => $i + 1]);
        }

        return back()->with('status', 'Cover photo changed.');
    }

    public function destroyImage(ProductImage $image)
    {
        File::delete(public_path($image->path));
        $image->delete();

        return back()->with('status', 'Photo removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'category'     => ['required', 'in:' . implode(',', array_keys(Product::CATEGORIES))],
            'description'  => ['nullable', 'string'],
            'price'        => ['required', 'numeric', 'min:0'],
            'cost_price'   => ['required', 'numeric', 'min:0'],
            'initial_sold' => ['nullable', 'integer', 'min:0'],
            'images'       => ['nullable', 'array', 'max:' . self::MAX_PHOTOS],
            'images.*'     => ['mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
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