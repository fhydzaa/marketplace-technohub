<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    public function product()
    {
        return $this->belongsToMany(Product::class, 'transaction_details', 'transaction_id', 'product_id')
                    ->withPivot('qty')
                    ->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
