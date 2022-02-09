<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function productVariant(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\ProductVariant');
    }
    protected $fillable = ['name', '3rd_level_category_id', 'collection_id', 'relevant', 'sex', 'description', 'price', 'src_image'];
}
