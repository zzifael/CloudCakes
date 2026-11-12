<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['invoice_number', 'user_id', 'customer_id', 'total_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}