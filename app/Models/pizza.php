<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pizza extends Model
{
    use HasFactory;

    protected $fillable=[
        'pizza_id',
        'pizza_name',
        'image',
        'price',
        'publish_status',
        'category_id',
        'discount_price',
        'buy_one_get_one_status',
        'waiing_time',
        'description'
    ];
}
