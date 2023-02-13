<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function adminpage()
    {
        return view("admin.desboard");
    }

    public function index()
    {

        $sql = "round(price + ((price / 100) * vat)) as price";
        $negyrandom = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('quantity', '>', 0)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();
        $layout = Product::layout();
        return view('user.welcome', compact('layout', 'negyrandom'));
    }

    /* public function index()
     {
     return view("welcome");
     }*/

    public function addcateg1(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory1')
            ->where('subcategory', '=', $request->select1)
            ->groupBy('subcategory1')
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory1 . "'>";
        }
    }

    public function addcateg2(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory2')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->groupBy('subcategory2')
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory2 . "'>";
        }
    }

    public function addcateg3(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory3')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->groupBy('subcategory3')
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory3 . "'>";
        }
    }

    public function addcateg4(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory4')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->where('subcategory3', '=', $request->select4)
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory4 . "'>";
        }
    }

    public function categ1(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory1')
            ->where('subcategory', '=', $request->select1)
            ->groupBy('subcategory1')
            ->get();

        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory1 . "'>" . $li->subcategory1 . "</option>";
        }
    }

    public function categ2(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory2')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->groupBy('subcategory2')
            ->get();
        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory2 . "'>" . $li->subcategory2 . "</option>";
        }
    }

    public function categ3(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory3')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->groupBy('subcategory3')
            ->get();
        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory3 . "'>" . $li->subcategory3 . "</option>";
        }
    }

    public function categ4(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory4')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->where('subcategory3', '=', $request->select4)
            ->get();
        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory4 . "'>" . $li->subcategory4 . "</option>";
        }
    }

    public function create()
    {
        $category = DB::table('categories')
            ->select('subcategory')
            ->groupBy('subcategory')
            ->get();
        $brand = DB::table('brands')
            ->select('*')
            ->get();
        return view('admin.create', compact('category'), compact('brand'));
    }
}
