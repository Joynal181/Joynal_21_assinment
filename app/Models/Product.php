<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];

    protected $hidden = ['created_at','updated_at'];
}
