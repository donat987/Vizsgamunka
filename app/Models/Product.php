<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'categoryid',
        'userid',
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
        'file',
        'capacity',
        'link',
        'active'
    ];
    public static function layout()
    {
        $category = DB::table('categories')
            ->select('subcategory2')
            ->groupBy('subcategory2')
            ->where('subcategory', '=', 'Ital')
            ->get();
        $country = DB::table('categories')
            ->select('subcategory1')
            ->groupBy('subcategory1')
            ->where('subcategory', '=', 'Ital')
            ->get();

        return compact('category', 'country');
    }
}
