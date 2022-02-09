<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping_cart_content extends Model
{
    protected $table = 'shopping_carts_content';
    protected $fillable = ['shopping_cart_id', 'product_variants_id', 'product_count'];
    use HasFactory;
}
