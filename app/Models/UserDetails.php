<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $table = 'user_details';

    protected $fillable = ['user_id', 'gender', 'no_telephone', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
