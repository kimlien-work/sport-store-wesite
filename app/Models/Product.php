<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // (Tùy chọn) Khai báo các trường được phép Mass Assignment
    protected $fillable = [
    'name', 
    'slug', 
    'description', 
    'price', 
    'sale_price', 
    'category_id', 
    'stock', 
    'is_active'
];
    // ==========================================
    // ĐIỀN CÁC HÀM RELATIONSHIP VÀO ĐÂY
    // ==========================================

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function mainImage() {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
}
