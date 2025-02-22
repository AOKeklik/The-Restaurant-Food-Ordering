<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class,"category_id");
    }

    public function product_sizes()
    {
        return $this->hasMany(ProductSizes::class)->where("status",1);
    }

    public function product_photos()
    {
        return $this->hasMany(ProductImage::class)->where("status",1);
    }

    
}
