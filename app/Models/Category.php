<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'cid';

    protected $fillable = [
        'category_name',
        'category_desc',
        'parent_id',
        'sort_order'
    ];

    // Define relationship to parent category
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'cid');
    }

    // Define relationship to child categories
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'cid');
    }
}
