<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'client_id', 'quantity', 'ip_address'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'pid');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
