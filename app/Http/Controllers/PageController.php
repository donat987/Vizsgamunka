<?php

namespace App\Http\Controllers;

use App\Mail\Picking_upMail;
use App\Models\Order;
use App\Models\Ordered_product;
use App\Models\Product;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class PageController extends Controller
{
    public function adminpage()
    {

        return view("admin.desboard");
    }
    public function ordershowsave(Request $request)
    {
        $order = DB::table('ordered_products')
            ->select('*')
            ->where('ordersid', '=', $request->id)
            ->get();
        $temp1 = 0;
        $temp2 = 0;
        foreach ($order as $s) {
            $update = Ordered_product::find($s->id);
            $db = 0;
            if ($request->has("csomagolva")) {
                foreach ($request->input('csomagolva') as $sor) {
                    if ($sor == $s->productsid) {
                        $update->packed = 1;
                        $db = 1;
                        $temp2 += 1;
                    }
                }
            }
            if ($db == 0) {
                $update->packed = 0;
            }
            $temp1 += 1;
            $update->update();
        }
        if ($temp1 == $temp2) {
            $orders = DB::table('ordered_products')->select('name', 'piece', 'gross_amount')->join('products', 'products.id', '=', 'ordered_products.productsid')->where('ordersid', '=', $request->id)->get();
            Cookie::queue('orders', json_encode($orders), 60);
            $sql = DB::table('orders')
                ->select('orders.id as id', 'orders.name', 'city', 'orders.email as email', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
                ->join('users', 'users.id', '=', 'orders.userid')
                ->join('states', 'states.id', '=', 'orders.statesid')
                ->where('orders.id', '=', $request->id)
                ->get();
            $netto = 0;
            $brutto = 0;
            foreach (DB::table('ordered_products')->select('*')->where('ordersid', '=', $request->id)->get() as $sor) {
                $brutto += round($sor->gross_amount);
                $netto += round($sor->clear_amount);
            }
            $freight_price = 1500;
            $final = $brutto + $freight_price;

            $mailData = [
                'name' => $sql[0]->name,
                'productid' => $request->id,
                'date' => $sql[0]->date,
                'mobil' => $sql[0]->mobile_number,
                'house_number' => $sql[0]->house_number,
                'comment' => $sql[0]->other,
                'zipcode' => $sql[0]->zipcode,
                'city' => $sql[0]->city,
                'street' => $sql[0]->street,
                'tax_number' => $sql[0]->tax_number,
                'company_name' => $sql[0]->company_name,
                'company_zipcode' => $sql[0]->company_zipcode,
                'company_city' => $sql[0]->company_city,
                'company_street' => $sql[0]->company_street,
                'company_house_number' => $sql[0]->company_house_number,
                'taxprice' => $brutto,
                'price' => $netto,
                'finalprice' => $final,
                'freight_price' => $freight_price,
                'status' => "Várakozás a feladásra"
            ];
            Mail::to($sql[0]->email)->send(new Picking_upMail($mailData));
            $update = Order::find($request->id);
            $update->statesid = 3;
            $update->update();
            return redirect("/admin/rendelesek");
        }
        return back();
    }
    public function ordershow($request)
    {
        Cookie::queue(Cookie::forget('orders'));
        $product = DB::table('ordered_products')
            ->select('*')
            ->join('products', 'products.id', '=', 'ordered_products.productsid')
            ->where('ordered_products.ordersid', '=', $request)
            ->get();
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'orders.email as email', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('orders.id', '=', $request)
            ->where('statesid', '<', 3)
            ->get();


        if (DB::table('orders')->where('statesid', '=', 1)->where('id', '=', $request)->count() == 1) {
            $orders = DB::table('ordered_products')->select('name', 'piece', 'gross_amount')->join('products', 'products.id', '=', 'ordered_products.productsid')->where('ordersid', '=', $request)->get();
            //dd($orders);
            Cookie::queue('orders', json_encode($orders), 60);
            dd(json_decode(Cookie::get('orders')));
            $netto = 0;
            $brutto = 0;
            foreach (DB::table('ordered_products')->select('*')->where('ordersid', '=', $request)->get() as $sor) {
                $brutto += round($sor->gross_amount);
                $netto += round($sor->clear_amount);
            }
            $freight_price = 1500;
            $final = $brutto + $freight_price;
            $mailData = [
                'name' => $sql[0]->name,
                'productid' => $request,
                'date' => $sql[0]->date,
                'mobil' => $sql[0]->mobile_number,
                'house_number' => $sql[0]->house_number,
                'comment' => $sql[0]->other,
                'zipcode' => $sql[0]->zipcode,
                'city' => $sql[0]->city,
                'street' => $sql[0]->street,
                'tax_number' => $sql[0]->tax_number,
                'company_name' => $sql[0]->company_name,
                'company_zipcode' => $sql[0]->company_zipcode,
                'company_city' => $sql[0]->company_city,
                'company_street' => $sql[0]->company_street,
                'company_house_number' => $sql[0]->company_house_number,
                'taxprice' => $brutto,
                'price' => $netto,
                'finalprice' => $final,
                'freight_price' => $freight_price,
                'status' => "Csomagolás alatt",
            ];
            Mail::to($sql[0]->email)->send(new Picking_upMail($mailData));
            $update = Order::find($request);
            $update->statesid = 2;
            $update->update();
        }
        return view("admin.ordershow", compact('sql', 'product'));
    }
    public function order()
    {
        Cookie::queue(Cookie::forget('orders'));
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('statesid', '<', 3)
            ->get();
        return view("admin.order", compact('sql'));
    }

    public function index()
    {
        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(point) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as points";
        $negyrandom = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->where('categories.subcategory2', '=', 'Pálinka')
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();

        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(point) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as points";
        $negyrandombor = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->where('categories.subcategory2', '=', 'Bor')
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();

        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(point) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as points";
        $negyrandomwiskey = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->where('categories.subcategory2', '=', 'Whiskey')
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();

        $layout = Product::layout();
        return view('user.welcome', compact('layout', 'negyrandom', 'negyrandomwiskey', 'negyrandombor'));
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
