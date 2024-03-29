<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_adresses extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid',
        'name',
        'city',
        'street',
        'house_number',
        'other',
        'tax_number',
        'mobile_number',
        'company_name',
        'company_zipcode',
        'company_city',
        'company_street',
        'company_house_number',
    ];
}
