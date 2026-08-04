<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- THÊM DÒNG NÀY
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'role'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders() {
    return $this->hasMany(Order::class);
}

public function reviews() {
    return $this->hasMany(Review::class);
}

public function cart() {
    return $this->hasOne(Cart::class);
}public function wishlist()
{
    return $this->hasMany(Wishlist::class);
}
}
