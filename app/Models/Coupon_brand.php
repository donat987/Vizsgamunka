<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon_brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'couponid',
        'brandid'
    ];
}
