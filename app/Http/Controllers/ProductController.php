<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function star(Request $request)
    {
       // $message =  $request->rating;
        //echo "<script type='text/javascript'>alert('$message');</script>";
        if(isset(Auth::user()->username)){
            $evolutionsave = new Evaluation();
            $evolutionsave->userid = Auth::user()->id;
            $evolutionsave->point = $request->point;
            $evolutionsave->productid = $request->productid;
            $evolutionsave->comment = $request->comment;
            $evolutionsave->save();
        }
        else{
            $message =  $request->rating;
            echo "<script type='text/javascript'>alert('Előbb jelentkezz be!');</script>";
        }
    }

    public function search(Request $request)
    {
        $sql = "round(price + ((price / 100) * vat)) as price, round(actionprice + ((actionprice / 100) * vat)) as actionprice , COUNT(1) as db, round(AVG(evaluations.point)*20) as point";
        $tep = explode(" ", $request->input('keres'));
        $keres = "";
        $temp = 0;
        for ($i=0; $i < count($tep); $i++) {
            if($temp == 0){
                $keres .= "tags like '%".$tep[$i]."%'";
                $temp = 1;
            }
            else{
                $keres .= "and tags like '%".$tep[$i]."%'";
            }
        }
        $se = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->join('evaluations', 'evaluations.productid', '=', 'products.id')
            ->where('quantity', '>', 0)
            ->whereraw($keres)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->paginate(16, ['*'], 'oldal');
        $layout = Product::layout();
        return view('user.search', compact('layout', 'se'));

    }

    public function productshow($link)
    {
        $point = DB::table('products')
        ->select(DB::raw("round(AVG(evaluations.point)) as point"))
        ->join('evaluations','evaluations.productid','=','products.id')
        ->groupBy('evaluations.point')
        ->where('products.link' , '=' , $link)
        ->get();
        $sql = 'DATE_FORMAT(evaluations.updated_at, "%Y %M %d") as date';
        $data = DB::connection()->getPdo()->query("SET lc_time_names = 'hu_HU'");
        $comment = DB::table('products')
        ->select('evaluations.point as point', 'evaluations.comment as comment' , 'users.username as username' , 'users.file as file')
        ->selectRaw($sql)
        ->join('evaluations','evaluations.productid','=','products.id')
        ->join('users','users.id','=','evaluations.userid')
        ->where('link' , '=' , $link)
        ->paginate(16, ['*'], 'oldal');
        $product = DB::table('products')
            ->select('*')
            ->where('link', '=', $link)
            ->get();
        $layout = Product::layout();
        return view('user.product', compact('layout' ,'comment', 'point','product'));
    }

    public function all()
    {
        $sql = "round(price + ((price / 100) * vat)) as price,";
        $sql .= "round(actionprice + ((actionprice / 100) * vat)) as actionprice,  COUNT(1) as db, round(AVG(evaluations.point)*20) as point";
        //$sql .= "round(AVG(point)) AS pont";
        $all = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->join('evaluations', 'evaluations.productid', '=', 'products.id')
            ->where('quantity', '>', 0)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->paginate(16, ['*'], 'oldal');
            $layout = Product::layout();
            return view('user.all', compact('layout', 'all'));
    }

    public function action()
    {
        $sql = "round(price + ((price / 100) * vat)) as price,";
        $sql .= "round(actionprice + ((actionprice / 100) * vat)) as actionprice  , COUNT(1) as db, round(AVG(evaluations.point)*20) as point";
        //$sql .= "round(AVG(point)) AS pont";
        $ac = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->join('evaluations', 'evaluations.productid', '=', 'products.id')
            ->where('quantity', '>', 0)
            ->where('active', '=', 1)
            ->where('actionprice', '>', 0)
            ->groupBy('products.id')
            ->paginate(16, ['*'], 'oldal');
            $layout = Product::layout();
            return view('user.action', compact('layout', 'ac'));
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
            $cat1 = $request->categoryselect1;
            $cat2 = $request->categoryselect2;
            $cat3 = $request->categoryselect3;
            $cat4 = $request->categoryselect4;
            $cat5 = $request->categoryselect5;
            $other = request("other");
            $description = request("description");
            if(request("description") == NULL){
                $description = "";
            }
            if(request("other") == NULL){
                $other = "";
            }
            if($request->categoryselect1 == NULL){
                $cat1 = "";
            }
            if($request->categoryselect2 == NULL){
                $cat2 = "";
            }
            if($request->categoryselect3 == NULL){
                $cat3 = "";
            }
            if($request->categoryselect4 == NULL){
                $cat4 = "";
            }if($request->categoryselect5 == NULL){
                $cat5 = "";
            }
            $catid = DB::table('categories')
                ->select('id')
                ->where('subcategory', 'like', $cat1)
                ->where('subcategory1', 'like', $cat2)
                ->where('subcategory2', 'like', $cat3)
                ->where('subcategory3', 'like', $cat4)
                ->where('subcategory4', 'like', $cat5)
                ->get();
            foreach ($catid as $i) {
                $save->categoryid = $i->id;
            }
            if(!request("actionprice")){
                $save->actionprice = 0;
            }else{
                $save->actionprice = request("actionprice");
            }
            $tagstemp = "";
            $bandname = DB::table('brands')
                ->select('*')
                ->where('id', '=', request("brandselect"))
                ->get();
            foreach ($bandname as $i){
                $t = explode(" ", $i->name);
                foreach($t as $v){
                    $tagstemp .= $v . ", ";
                }
            }
            $darabol = explode(" ", request("name"));
            foreach($darabol as $i){
                $tagstemp .= $i . ", ";

            }
            $tagstemp .= $request->categoryselect1 . ", " . $request->categoryselect2 . ", " . $request->categoryselect3 . ", " . $request->categoryselect4;
            $tagstemp = explode(", ", $tagstemp);
            $tags = "";
            $db = 0;
            foreach($tagstemp as $i){
                $p = explode(", ", $tags);
                $vanbenne = 0;
                foreach($p as $q){
                    if($q == $i){
                        $vanbenne = 1;
                    }
                }
                if($vanbenne == 0){
                    if($db == 0){
                        $tags .= $i;
                        $db = 1;
                    }
                    else{
                        $tags .= ", " . $i;
                    }
                }
            }
            $save->tags = $tags;
            $save->price = request("price");
            $save->barcode = request("barcode");
            $save->quantity = request("quantity");
            $save->other = $other;
            $save->capacity = request("liter");
            $save->vat = request("vat");
            if(request("active")=="on"){
                $save->active = 1;
            }
            else{
                $save->active = 0;
            }

            $save->picturename = $renames;
            $save->file = '/storage/' . $picture;
            $save->description = $description;
            $save->userid = Auth::user()->id;
            $save->link = "";

            $save->save();

            $productid = DB::table('products')
            ->select('id')
            ->orderBy('products.id','desc')
            ->limit(1)
            ->get();
            $link = $productid[0]->id . "_";
            $darabol = explode(" ", request("name"));
            $db = 0;
            foreach($darabol as $i){
                if($db == 0){
                    $db = 1;
                    $link .= $i;
                }
                else{
                    $link .= "_" . $i;
                }
            }
            $ok = DB::update('update products set link = "'.$link.'" where id = "'.$productid[0]->id.'"');
            return back()
                ->with('success', 'Sikeres mentés')
                ->with('file', $picture);
        }
    }
}
