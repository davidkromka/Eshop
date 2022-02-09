<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Eloquent;

class ProductVariant extends Model
{
    use HasFactory;

    public $timestamps = false;
    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Product');
    }

    protected $fillable = ['product_id', 'color_id', 'size', 'stock'];
}
