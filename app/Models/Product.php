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

    public function product_ratings()
    {
        return $this->hasMany(productRating::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_details', 'product_id', 'transaction_id')
                    ->withPivot('qty')
                    ->withTimestamps();
    }
}
