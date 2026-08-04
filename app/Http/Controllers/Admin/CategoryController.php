<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $data = $request->only(['name', 'description', 'parent_id']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = $path;
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo.');
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $data = $request->only(['name', 'description', 'parent_id']);
        $data['slug'] = $request->slug ?: Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = $path;
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Không thể xóa danh mục đang có sản phẩm.');
        }
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa.');
    }
}