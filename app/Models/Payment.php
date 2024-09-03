<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model

{
    protected $fillable = [
        'payment_id',
        'payment_status',
        'total_payment',
        'order_id',
    ];

    // Assuming 'payment_id' is the primary key
    protected $primaryKey = 'payment_id';




    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
