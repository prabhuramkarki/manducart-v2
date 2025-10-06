<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    use HasFactory;

    protected $table = 'product_categories';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'product_category',
        'product_color',
        'product_size',
        'status',
        'created_by',
        'updated_by'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}

