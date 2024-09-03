<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'cid',
        'product_name',
        'product_desc',
        'product_price',
        'product_weight',
    ];

    protected $primaryKey = 'pid';

    protected $table = 'products'; // Specify the table name if different from the model name

    // Define relationship to category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cid', 'cid');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'id');
    }
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'product_id', 'pid'); // Foreign key and local key
    // }
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'pid');
    }
}
