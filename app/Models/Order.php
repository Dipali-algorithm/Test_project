<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'address_id',
        'total_payment',
        'order_id',
        'order_status',
        'shipping_id',
        'product_id',
        'mobile',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    // public function products()
    // {
    //     return $this->belongsToMany(Products::class);
    // }
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'id');
    // }
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'pid');
    }
}
