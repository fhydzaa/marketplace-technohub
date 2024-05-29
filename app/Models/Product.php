<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    
    public function product_image()
    {
        return $this->hasMany(ProductImage::class);
    }
}
