<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'statesid',
        'userid',
        'zipcode',
        'name',
        'city',
        'street',
        'house_number',
        'other',
        'tax_number',
        'mobile_number',
        'email',
        'shippingid',
        'couponid',
        'company_name',
        'company_zipcode',
        'company_city',
        'company_street',
        'company_house_number'
    ];
}
