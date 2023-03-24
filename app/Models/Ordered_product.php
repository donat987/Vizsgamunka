<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordered_product extends Model
{
    use HasFactory;
    protected $fillable = [
        'ordersid',
        'productsid',
        'clear_amount',
        'gross_amount',
        'piece',
        'packed'
    ];
}
