<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url',
            'active' => 'boolean',
        ]);

        $data = $request->only(['title', 'link']);
        $data['active'] = $request->has('active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image'] = $path;
        }

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được tạo.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'active' => 'boolean',
        ]);

        $data = $request->only(['title', 'link']);
        $data['active'] = $request->has('active');

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $path = $request->file('image')->store('banners', 'public');
            $data['image'] = $path;
        }

        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được cập nhật.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner đã được xóa.');
    }
}