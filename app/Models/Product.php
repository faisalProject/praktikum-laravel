<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $fillable = ['product_name', 'product_type', 'product_price', 'expired_at'];
    protected $dates = ['deleted_at'];

    public function categories() {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
