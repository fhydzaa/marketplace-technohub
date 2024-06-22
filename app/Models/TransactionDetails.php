<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $table = 'transaction_details';

    public function transactionLicense()
    {
        return $this->hasMany(TransactionLisense::class);
    }
}
