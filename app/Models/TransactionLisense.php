<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLisense extends Model
{
    protected $table = 'transaction_lisense';

    public function transactionDetail()
    {
        return $this->belongsTo('App\Models\TransactionDetail');
    }
}


