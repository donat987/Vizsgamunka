<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $save = new Category();
        $sub1 = "";
        $sub2 = "";
        $sub3 = "";
        $sub4 = "";
        $sub5 = "";
        if(request("subcategory")){
            $sub1 = request("subcategory");
        }
        if(request("subcategory1")){
            $sub2 = request("subcategory1");
        }
        if(request("subcategory2")){
            $sub3 = request("subcategory2");
        }
        if(request("subcategory3")){
            $sub4 = request("subcategory3");
        }
        if(request("subcategory4")){
            $sub5 = request("subcategory4");
        }
        $save->subcategory = $sub1;
        $save->subcategory1 = $sub2;
        $save->subcategory2 =$sub3;
        $save->subcategory3 =$sub4;
        $save->subcategory4 = $sub5;
        $save->save();
        return back();
    }
}
