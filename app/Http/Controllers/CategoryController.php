<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $save = new Category();
        $save->subcategory = request("subcategory");
        $save->subcategory1 = request("subcategory1");
        $save->subcategory2 = request("subcategory2");
        $save->subcategory3 = request("subcategory3");
        $save->subcategory4 = request("subcategory4");
        $save->save();
        return back();
    }
}
