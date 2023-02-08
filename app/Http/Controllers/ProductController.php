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
        $sql = "round(price + ((price / 100) * vat)) as price,";
        $sql .= "round(actionprice + ((actionprice / 100) * vat)) as actionprice";
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
            ->where('quantity', '>', 0)
            ->whereraw($keres)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->paginate(16, ['*'], 'oldal');
            return view('user.search', compact('se'));
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
        ->select('evaluations.point as point', 'evaluations.comment as comment' , 'users.username as username')
        ->selectRaw($sql)
        ->join('evaluations','evaluations.productid','=','products.id')
        ->join('users','users.id','=','evaluations.userid')
        ->where('link' , '=' , $link)
        ->paginate(16, ['*'], 'oldal');
        $product = DB::table('products')
            ->select('*')
            ->where('link', '=', $link)
            ->get();
        return view('user.product', compact('comment', 'point','product'));
    }

    public function all()
    {
        $sql = "round(price + ((price / 100) * vat)) as price,";
        $sql .= "round(actionprice + ((actionprice / 100) * vat)) as actionprice";
        //$sql .= "round(AVG(point)) AS pont";
        $all = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('quantity', '>', 0)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->paginate(16, ['*'], 'oldal');

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
            ->paginate(16, ['*'], 'oldal');
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
