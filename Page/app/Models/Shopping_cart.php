<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping_cart extends Model
{
    protected $fillable = ['user_id', 'last_time_active', 'discount_id'];
    use HasFactory;
}
