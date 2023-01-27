<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:img,png,jpg|max:2048'
        ]);
        $save = new Product();
        if ($request->file()) {
            $renames = time() . '_' . rand() . $request->file->getClientOriginalName();
            $picture = $request->file('file')->storeAs('product', $renames, 'public');
            $save->name = request("name");
            $save->brandid = request("brandselect");
            $catid = DB::table('categories')
                ->select('id')
                ->where('subcategory', 'like', $request->categoryselect1)
                ->where('subcategory1', 'like', $request->categoryselect2)
                ->where('subcategory2', 'like', $request->categoryselect3)
                ->where('subcategory3', 'like', $request->categoryselect4)
                ->where('subcategory4', 'like', $request->categoryselect5)
                ->get();
            foreach ($catid as $i) {
                $save->categoryid = $i->id;
            }
            if(!request("actionprice")){
                $save->actionprice = 0;
            }else{
                $save->actionprice = request("actionprice");
            }
            $save->price = request("price");
            $save->barcode = request("barcode");
            $save->quantity = request("quantity");
            $save->other = request("other");
            $save->tags = request("tags");
            $save->vat = request("vat");
            if(request("active")=="on"){
                $save->active = 1;
            }
            else{
                $save->active = 0;
            }

            $save->picturename = $renames;
            $save->file = '/storage/' . $picture;
            $save->description = request("description");
            $save->save();
            return back()
                ->with('success', 'Sikeres mentés')
                ->with('file', $picture);
        }
    }
}
