<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function all()
    {
        $sql = "round(price + ((price / 100) * vat)) as price,";
        $sql .= "round(actionprice + ((actionprice / 100) * vat)) as actionprice";
        //$sql .= "round(AVG(point)) AS pont";
        $all = DB::table('products')
            ->select('products.id as id', 'name', 'file')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('quantity', '>', 0)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->paginate(16);
            return view('user.all', compact('all'));
    }

    public function action()
    {
        $sql = "round(price + ((price / 100) * vat)) as price,";
        $sql .= "round(actionprice + ((actionprice / 100) * vat)) as actionprice";
        //$sql .= "round(AVG(point)) AS pont";
        $ac = DB::table('products')
            ->select('products.id as id', 'name', 'file')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('quantity', '>', 0)
            ->where('active', '=', 1)
            ->where('actionprice', '>', 0)
            ->groupBy('products.id')
            ->get();
            return view('user.action', compact('ac'));
    }
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
