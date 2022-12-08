<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'categoryid',
        'vat',
        'brandid',
        'barcode',
        'description',
        'price',
        'actionprice',
        'quantity',
        'other',
        'tags',
        'picturename',
        'file_path',
        'active'
    ];
}
