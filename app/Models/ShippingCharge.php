<?php

namespace App\Models;

// use app\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $fillable = ['item_id', 'rate']; // Adjust column names as per your database
    protected $table = 'shipping_charges';

    public function product()
    {
        return $this->belongsTo(Products::class, 'pid'); // Ensure this matches your foreign key
    }
}
