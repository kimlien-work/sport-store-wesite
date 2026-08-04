<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'mainImage')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'image|max:2048',
            'variants' => 'array',
            'variants.*.size' => 'nullable|string',
            'variants.*.color' => 'nullable|string',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.price' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only(['name', 'description', 'category_id', 'price', 'sale_price', 'stock', 'is_active']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $product = Product::create($data);

        // Upload ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => !$product->images()->exists(), // ảnh đầu tiên làm main
                ]);
            }
        }

        // Lưu biến thể
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['size']) || !empty($variant['color'])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $variant['size'] ?? null,
                        'color' => $variant['color'] ?? null,
                        'stock' => $variant['stock'],
                        'price' => $variant['price'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'image|max:2048',
            'delete_images' => 'array',
            'delete_images.*' => 'exists:product_images,id',
            'variants' => 'array',
        ]);

        $data = $request->only(['name', 'description', 'category_id', 'price', 'sale_price', 'stock']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        $product->update($data);

        // Xóa ảnh được chọn
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = ProductImage::find($imgId);
                if ($img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        // Upload ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_main' => !$product->images()->exists(),
                ]);
            }
        }

        // Cập nhật biến thể (cả hiện có và thêm mới)
        if ($request->has('variants')) {
            // Lấy danh sách id hiện có
            $existingIds = $product->variants->pluck('id')->toArray();
            $updatedIds = [];

            foreach ($request->variants as $variantData) {
                if (isset($variantData['id'])) {
                    // Cập nhật biến thể cũ
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant) {
                        $variant->update([
                            'size' => $variantData['size'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'stock' => $variantData['stock'] ?? 0,
                            'price' => $variantData['price'] ?? null,
                        ]);
                        $updatedIds[] = $variant->id;
                    }
                } else {
                    // Thêm mới biến thể
                    if (!empty($variantData['size']) || !empty($variantData['color'])) {
                        $newVariant = ProductVariant::create([
                            'product_id' => $product->id,
                            'size' => $variantData['size'] ?? null,
                            'color' => $variantData['color'] ?? null,
                            'stock' => $variantData['stock'] ?? 0,
                            'price' => $variantData['price'] ?? null,
                        ]);
                        $updatedIds[] = $newVariant->id;
                    }
                }
            }

            // Xóa các biến thể không còn trong danh sách
            $toDelete = array_diff($existingIds, $updatedIds);
            ProductVariant::whereIn('id', $toDelete)->delete();
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật.');
    }

    public function destroy(Product $product)
    {
        // Xóa ảnh
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }
        $product->images()->delete();

        // Xóa biến thể (cascade sẽ tự động)
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa.');
    }
}