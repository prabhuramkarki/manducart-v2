<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'category_id',
        'product_name',
        'product_details',
        'product_quantity',
        'product_price',
        'rating',
        'created_by',
        'product_image',
        'product_image2',
        'product_image3',
        'product_image4',
        'status',
        'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategories::class, 'category_id', 'category_id');
    }
}
