<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    // Relasi One-to-Many ke model Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}