<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'discount_amount',
        'discount_percentage',
        'couponcode',
        'start',
        'end',
        'active',
        'speciesid',
        'piece'
    ];
}
