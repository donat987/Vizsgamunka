<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function star(Request $request)
    {
        // $message =  $request->rating;
        //echo "<script type='text/javascript'>alert('$message');</script>";
        if (isset(Auth::user()->username)) {
            $evolutionsave = new Evaluation();
            $evolutionsave->userid = Auth::user()->id;
            $evolutionsave->point = $request->point;
            $evolutionsave->productid = $request->productid;
            $evolutionsave->comment = $request->comment;
            $evolutionsave->save();
        } else {
            $message = $request->rating;
            echo "<script type='text/javascript'>alert('Előbb jelentkezz be!');</script>";
        }
    }

    public function search(Request $request)
    {
        $category = DB::table('categories')
            ->select('subcategory2 as category')
            ->groupBy('subcategory2')
            ->orderBy('subcategory2', 'asc')
            ->get();

        $country = DB::table('categories')
            ->select('subcategory1 as country')
            ->groupBy('subcategory1')
            ->orderBy('subcategory1', 'asc')
            ->get();

        $sql = "max(round(price + ((price / 100) * vat))) as max";
        $m = DB::table('products')
            ->selectraw($sql)
            ->get();

        $maxprice = $m[0]->max;
        $sql = "min(round(price + ((price / 100) * vat))) as min";
        $m = DB::table('products')
            ->selectraw($sql)
            ->get();
        $minprice = $m[0]->min;

        $m = DB::table('products')
            ->select('capacity')
            ->groupBy('capacity')
            ->orderBy('capacity', 'asc')
            ->limit(1)
            ->get();
        $mincapacity = floatval($m[0]->capacity);

        $m = DB::table('products')
            ->select('capacity')
            ->groupBy('capacity')
            ->orderBy('capacity', 'desc')
            ->limit(1)
            ->get();
        $maxcapacity = floatval($m[0]->capacity);

        $tep = explode(" ", $request->input('keres'));
        $keres = "";
        $akcio = "";
        $temp = 0;
        for ($i = 0; $i < count($tep); $i++) {
            if ($temp == 0) {
                $keres .= "tags like '%" . $tep[$i] . "%'";
                $temp = 1;
            } else {
                $keres .= "and tags like '%" . $tep[$i] . "%'";
            }
        }
        $akciokeres = "products.actionprice >= 0";
        $min = 0;
        $max = $maxprice;
        $minmax = "";
        if ($request->has("min")) {
            $min = $request->input("min");
        }
        if ($request->has("max")) {
            $max = $request->input("max");
        }
        if ($request->has("akcio")) {
            if ($request->input("akcio") == 1) {
                $akciokeres = "products.actionprice > 0";
                $minmax = "ROUND(actionprice + ((actionprice / 100) * vat)) BETWEEN " . $min . " AND " . $max;

            } else {
                $akciokeres = "(products.actionprice > 0 or products.actionprice = 0)";
                $minmax = "(ROUND(price + ((price / 100) * vat)) BETWEEN " . $min . " AND " . $max . " OR ROUND(actionprice + ((actionprice / 100) * vat)) BETWEEN " . $min . " AND " . $max . ")";
            }
        } else {
            $akciokeres = "(products.actionprice > 0 or products.actionprice = 0)";
            $minmax = "(ROUND(price + ((price / 100) * vat)) BETWEEN " . $min . " AND " . $max . " OR ROUND(actionprice + ((actionprice / 100) * vat)) BETWEEN " . $min . " AND " . $max . ")";

        }
        $fajtakeres = "categories.subcategory2 like '%%'";
        if ($request->has("fajta")) {
            $fajtakeres = "(";
            $temp = 0;
            foreach ($request->input('fajta') as $faj) {
                if ($temp != 0) {
                    $fajtakeres .= " or ";
                }
                $temp += 1;
                $fajtakeres .= "categories.subcategory2 = '" . $faj . "'";
            }
            $fajtakeres .= ")";
        }
        $orszagkeres = "categories.subcategory1 like '%%'";
        if ($request->has("orszag")) {
            $orszagkeres = "(";
            $temp = 0;
            foreach ($request->input('orszag') as $faj) {
                if ($temp != 0) {
                    $orszagkeres .= " or ";
                }
                $temp += 1;
                $orszagkeres .= "categories.subcategory1 = '" . $faj . "'";
            }
            $orszagkeres .= ")";
        }

        $minliter = $mincapacity;
        $maxliter = $maxcapacity;
        if ($request->has("minimumurtartalom")) {
            $minliter = $request->input('minimumurtartalom');
        }
        if ($request->has("maximumurtartalom")) {
            $maxliter = $request->input('maximumurtartalom');
        }
        $liter = "products.capacity BETWEEN " . $minliter . " AND " . $maxliter . "";
        $order = "id";
        $temp = 0;

        if ($request->has("rendezesar")) {
            $temp = 1;
            if ($request->input("rendezesar") == 1) {
                $order = "price ";
            } elseif ($request->input("rendezesar") == 2) {
                $order = "price desc ";
            }elseif ($request->input("rendezesar") == 0) {
                $order = "id";
                $temp = 0;
            }
        }

        if ($request->has("rendezesert")) {
            if ($temp == 0) {
                if ($request->input("rendezesert") == 1) {
                    $order = "points, db ";
                } elseif ($request->input("rendezesert") == 2) {
                    $order = "points desc, db desc";
                }elseif ($request->input("rendezesert") == 0) {
                    $order = "id";
                }
            } else {
                if ($request->input("rendezesert") == 1) {
                    $order .= ", points, db ";
                } elseif ($request->input("rendezesert") == 2) {
                    $order .= ", points desc, db desc";
                }
            }
        }

        $sql = "round(price + ((price / 100) * vat)) as price, round(actionprice + ((actionprice / 100) * vat)) as actionprice , COUNT(point) as db, round(AVG(evaluations.point)*20) as points";

        $se = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectraw($sql)
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->where('quantity', '>', 0)
            ->whereraw($minmax)
            ->whereraw($keres)
            ->whereraw($liter)
            ->whereraw($fajtakeres)
            ->whereraw($orszagkeres)
            ->whereraw($akciokeres)
            ->where('active', '=', 1)
            ->groupBy('products.id')
            ->orderByRaw($order)
            ->paginate(15, ['*'], 'oldal');
        $layout = Product::layout();
        return view('user.search', compact('layout', 'se', 'maxprice', 'category', 'country', 'minprice', 'maxcapacity', 'mincapacity'));

    }

    public function productshow($link)
    {
        $point = DB::table('products')
            ->select(DB::raw("round(AVG(evaluations.point)) as point"))
            ->join('evaluations', 'evaluations.productid', '=', 'products.id')
            ->groupBy('evaluations.point')
            ->where('products.link', '=', $link)
            ->get();
        $sql = 'DATE_FORMAT(evaluations.updated_at, "%Y %M %d") as date';
        $data = DB::connection()->getPdo()->query("SET lc_time_names = 'hu_HU'");
        $comment = DB::table('products')
            ->select('evaluations.point as point', 'evaluations.comment as comment', 'users.username as username', 'users.file as file')
            ->selectRaw($sql)
            ->join('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('users', 'users.id', '=', 'evaluations.userid')
            ->where('link', '=', $link)
            ->paginate(16, ['*'], 'oldal');
        $sql = "round(price + ((price / 100) * vat)) as price, round(actionprice + ((actionprice / 100) * vat)) as actionprice";
        $product = DB::table('products')
            ->select('price as taxprice', 'actionprice as actiontaxprice', 'active', 'brandid', 'capacity', 'categoryid', 'vat', 'id', 'name', 'file', 'description', 'link')
            ->selectraw($sql)
            ->where('link', '=', $link)
            ->get();
        $layout = Product::layout();
        return view('user.product', compact('layout', 'comment', 'point', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:img,png,jpg|max:2048',
        ]);
        $save = new Product();
        if ($request->file()) {
            $valid = $request->validate([
                'file' => 'required|mimes:img,png,jpg|max:2048',
            ]);
            $image = $valid['file'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $explode = explode('/', Auth::user()->file);
            Storage::delete('/public/product/' . $explode[3]);
            $path = '/public/product/' . $filename;
            $file = '/storage/product/' . $filename;
            $img = Image::make($image);
            $img->fit(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put($path, (string) $img->encode());
            $save->name = request("name");
            $save->brandid = request("brandselect");
            $cat1 = $request->categoryselect1;
            $cat2 = $request->categoryselect2;
            $cat3 = $request->categoryselect3;
            $cat4 = $request->categoryselect4;
            $cat5 = $request->categoryselect5;
            $other = request("other");
            $description = request("description");
            if (request("description") == null) {
                $description = "";
            }
            if (request("other") == null) {
                $other = "";
            }
            if ($request->categoryselect1 == null) {
                $cat1 = "";
            }
            if ($request->categoryselect2 == null) {
                $cat2 = "";
            }
            if ($request->categoryselect3 == null) {
                $cat3 = "";
            }
            if ($request->categoryselect4 == null) {
                $cat4 = "";
            }if ($request->categoryselect5 == null) {
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
            if (!request("actionprice")) {
                $save->actionprice = 0;
            } else {
                $save->actionprice = request("actionprice");
            }
            $tagstemp = "";
            $bandname = DB::table('brands')
                ->select('*')
                ->where('id', '=', request("brandselect"))
                ->get();
            foreach ($bandname as $i) {
                $t = explode(" ", $i->name);
                foreach ($t as $v) {
                    $tagstemp .= $v . ", ";
                }
            }
            $darabol = explode(" ", request("name"));
            foreach ($darabol as $i) {
                $tagstemp .= $i . ", ";

            }
            $tagstemp .= $request->categoryselect1 . ", " . $request->categoryselect2 . ", " . $request->categoryselect3 . ", " . $request->categoryselect4;
            $tagstemp = explode(", ", $tagstemp);
            $tags = "";
            $db = 0;
            foreach ($tagstemp as $i) {
                $p = explode(", ", $tags);
                $vanbenne = 0;
                foreach ($p as $q) {
                    if ($q == $i) {
                        $vanbenne = 1;
                    }
                }
                if ($vanbenne == 0) {
                    if ($db == 0) {
                        $tags .= $i;
                        $db = 1;
                    } else {
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
            $save->alcohol = request("alcohol");
            $save->vat = request("vat");
            if (request("active") == "on") {
                $save->active = 1;
            } else {
                $save->active = 0;
            }

            $save->picturename = "";
            $save->file = $file;
            $save->description = $description;
            $save->userid = Auth::user()->id;
            $save->link = "";

            $save->save();

            $productid = DB::table('products')
                ->select('id')
                ->orderBy('products.id', 'desc')
                ->limit(1)
                ->get();
            $link = $productid[0]->id . "_";
            $darabol = explode(" ", request("name"));
            $db = 0;
            foreach ($darabol as $i) {
                if ($db == 0) {
                    $db = 1;
                    $link .= $i;
                } else {
                    $link .= "_" . $i;
                }
            }
            $ok = DB::update('update products set link = "' . $link . '" where id = "' . $productid[0]->id . '"');
            return back()
                ->with('success', 'Sikeres mentés');
        }
    }
}
