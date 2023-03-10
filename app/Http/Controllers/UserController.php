<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\User_adresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function titlesdelete($id)
    {
        $sql = DB::table('user_adresses')
            ->select(DB::raw("count(1) as van"))
            ->where('id', '=', $id)
            ->where('userid', '=', Auth::user()->id)
            ->get();
        if ($sql[0]->van != 0) {
            $delete = User_adresses::find($id);
            $delete->delete();
            return redirect('/profil/cimek');
        } else {
            return redirect('/profil/cimek');
        }
    }
    public function titlesupdatesave(Request $request)
    {
        $validated = $request->validate([
            'teljes_név' => 'required|min:5|max:50',
            'irányítószám' => 'required|numeric|digits:4',
            'település' => 'required|min:2|max:50',
            'utca' => 'required|min:2|max:50',
            'házszám' => 'required|min:1|max:7',
            'egyéb' => 'max:50',
            'telefonszám' => 'required|numeric',
        ]);
        $update = User_adresses::find($request->id);
        if (!$request->adószám) {
            $update->tax_number = "";
        } else {
            $update->tax_number = $request->adószám;
        }
        if (!$request->egyéb) {
            $update->other = "";
        } else {
            $update->other = $request->egyéb;
        }
        if (!$request->cégnév) {
            $update->company_name = "";
        } else {
            $update->company_name = $request->cégnév;
        }

        if (!$request->cég_irányítószám) {
            $update->company_zipcode = "";
        } else {
            $update->company_zipcode = $request->cég_irányítószám;
        }
        if (!$request->cég_település) {
            $update->company_city = "";
        } else {
            $update->company_city = $request->cég_település;
        }
        if (!$request->cég_utca) {
            $update->company_street = "";
        } else {
            $update->company_street = $request->cég_utca;
        }
        if (!$request->cég_házszám) {
            $update->company_house_number = "";
        } else {
            $update->company_house_number = $request->cég_házszám;
        }
        $update->userid = Auth::user()->id;
        $update->zipcode = $request->irányítószám;
        $update->name = $request->teljes_név;
        $update->city = $request->település;
        $update->street = $request->utca;
        $update->house_number = $request->házszám;
        $update->mobile_number = $request->telefonszám;
        $update->update();
        return redirect('/profil/cimek');
    }
    public function titlesupdate($id)
    {
        $sql = DB::table('user_adresses')
            ->select(DB::raw("count(1) as van"))
            ->where('id', '=', $id)
            ->where('userid', '=', Auth::user()->id)
            ->get();
        if ($sql[0]->van != 0) {
            $sql = DB::table('user_adresses')
                ->select(DB::raw("*"))
                ->where('id', '=', $id)
                ->where('userid', '=', Auth::user()->id)
                ->get();
            $layout = Product::layout();
            return view('user.editprofiltitles', compact('layout', 'sql'));
        } else {
            return redirect('/profil/cimek');
        }
    }
    public function addtitlessave(Request $request)
    {
        $validated = $request->validate([
            'teljes_név' => 'required|min:5|max:50',
            'irányítószám' => 'required|numeric|digits:4',
            'település' => 'required|min:2|max:50',
            'utca' => 'required|min:2|max:50',
            'házszám' => 'required|min:1|max:7',
            'egyéb' => 'max:50',
            'telefonszám' => 'required|numeric',
        ]);
        $save = new user_adresses();
        if (!$request->adószám) {
            $save->tax_number = "";
        } else {
            $save->tax_number = $request->adószám;
        }
        if (!$request->egyéb) {
            $save->other = "";
        } else {
            $save->other = $request->egyéb;
        }
        if (!$request->cégnév) {
            $save->company_name = "";
        } else {
            $save->company_name = $request->cégnév;
        }if (!$request->cég_irányítószám) {
            $save->company_zipcode = "";
        } else {
            $save->company_zipcode = $request->cég_irányítószám;
        }
        if (!$request->cég_település) {
            $save->company_city = "";
        } else {
            $save->company_city = $request->cég_település;
        }
        if (!$request->cég_utca) {
            $save->company_street = "";
        } else {
            $save->company_street = $request->cég_utca;
        }
        if (!$request->cég_házszám) {
            $save->company_house_number = "";
        } else {
            $save->company_house_number = $request->cég_házszám;
        }
        $save->userid = Auth::user()->id;
        $save->zipcode = $request->irányítószám;
        $save->name = $request->teljes_név;
        $save->city = $request->település;
        $save->street = $request->utca;
        $save->house_number = $request->házszám;
        $save->mobile_number = $request->telefonszám;
        $save->save();
        $sql = DB::table('user_adresses')
            ->select('*')
            ->where('userid', '=', Auth::user()->id)
            ->get();
        $layout = Product::layout();
        return view('user.profiltitles', compact('layout', 'sql'));

    }
    public function addtitles()
    {
        $layout = Product::layout();
        return view('user.addtitles', compact('layout'));
    }
    public function profiltitles()
    {
        $sql = DB::table('user_adresses')
            ->select('*')
            ->where('userid', '=', Auth::user()->id)
            ->get();
        $layout = Product::layout();
        return view('user.profiltitles', compact('layout', 'sql'));
    }

    public function profilupdatesave(Request $request)
    {

        $update = User::find(Auth::user()->id);
        if ($request->file()) {
            $valid = $request->validate([
                'file' => 'required|mimes:img,png,jpg|max:2048',
            ]);
            $image = $valid['file'];
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $explode = explode('/', Auth::user()->file);
            Storage::delete('/public/users/' . $explode[3]);
            $path = '/public/users/' . $filename;
            $file = '/storage/users/' . $filename;
            $img = Image::make($image);
            $img->fit(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            Storage::put($path, (string) $img->encode());
            $update->file = $file;
        }
        $validated = $request->validate([
            'vezetéknév' => 'required|min:3|max:20',
            'keresztnév' => 'required|min:3|max:20',
            'születési_dátum' => 'required|date',
            'felhasználónév' => 'required|min:3|max:20',
            'email' => 'required|email',
        ]);
        if (strtotime($request->születési_dátum . ' + 18 years') <= time()) {
            $sql = DB::table('users')
                ->select(DB::raw("count(username) as name"))
                ->where('username', '=', $request->felhasználónév)
                ->get();
            if ($sql[0]->name == 0 || $request->felhasználónév == Auth::user()->username) {
                $sql = DB::table('users')
                    ->select(DB::raw("count(email) as email"))
                    ->where('email', '=', $request->email)
                    ->get();
                if ($sql[0]->email == 0 || $request->email == Auth::user()->email) {
                    $update->firstname = $request->vezetéknév;
                    $update->lastname = $request->keresztnév;
                    $update->date_of_birth = $request->születési_dátum;
                    $update->username = $request->felhasználónév;
                    $update->email = $request->email;
                    $update->advertising = $request->advertising;
                    $update->update();
                    $layout = Product::layout();
                    return view('user.profil', compact('layout'));
                } else {
                    return redirect()->back()->with('error', 'Ez az emalcím foglalt!');
                }
            } else {
                return redirect()->back()->with('error', 'Ez a fálhasználónév foglalt!');
            }
        } else {
            return redirect()->back()->with('error', 'Még nem töltötte be a 18 életévét!');
        }

    }
    public function profilupdate()
    {

        $layout = Product::layout();
        return view('user.edituser', compact('layout'));
    }

    public function profiloldorder()
    {
        $sq = DB::table('orders')
            ->select('id')
            ->where('userid', '=', Auth::user()->id)
            ->where('statesid', '>', 4)
            ->paginate(3, ['*'], 'oldal');
        $orders = [];
        foreach ($sq as $sor) {
            $alorder = [];
            $sql = DB::table('orders')
                ->select('orders.zipcode as zipcode', 'orders.city as city', 'orders.street as street', 'orders.house_number as house_number', 'orders.other as other', 'orders.name as name', 'orders.mobile_number as mobile_number', 'orders.tax_number as tax_number', 'orders.company_name as company_name', 'orders.company_zipcode as company_zipcode', 'orders.company_city as company_city', 'orders.company_street as company_street', 'orders.company_house_number as company_house_number', 'orders.box_number as box_number', 'states.id as statesid', 'states.status as states', 'orders.created_at as date', 'ordered_products.piece as price', 'ordered_products.gross_amount', 'shipping_methods.price as shippingprice', 'orders.id as ordersid', 'products.file as file', 'products.name as products_name')
                ->join('ordered_products', 'ordered_products.ordersid', '=', 'orders.id')
                ->join('products', 'ordered_products.productsid', '=', 'products.id')
                ->join('states', 'states.id', '=', 'orders.statesid')
                ->join('shipping_methods', 'shipping_methods.id', '=', 'orders.shippingid')
                ->where('orders.userid', '=', Auth::user()->id)
                ->where('orders.id', '=', $sor->id)
                ->get();
            foreach ($sql as $a) {
                $alorder[] = ['zipcode' => $a->zipcode, 'city' => $a->city, 'street' => $a->street, 'house_number' => $a->house_number, 'other' => $a->other, 'name' => $a->name, 'mobile_number' => $a->mobile_number, 'tax_number' => $a->tax_number, 'company_name' => $a->company_name, 'company_zipcode' => $a->company_zipcode, 'company_city' => $a->company_city, 'company_street' => $a->company_street, 'company_house_number' => $a->company_house_number, 'box_number' => $a->box_number, 'statesid' => $a->statesid, 'states' => $a->states, 'date' => $a->date, 'price' => $a->price, 'gross_amount' => $a->gross_amount, 'shippingprice' => $a->shippingprice, 'ordersid' => $a->ordersid, 'file' => $a->file , 'products_name'=>$a->products_name];
            }
            $orders[] = $alorder;
        }

        $layout = Product::layout();
        return view('user.oldorders', compact('layout', 'orders', 'sq'));
    }
    public function profilorder()
    {
        $sq = DB::table('orders')
            ->select('id')
            ->where('userid', '=', Auth::user()->id)
            ->where('statesid', '<', 5)
            ->get();
        $orders = [];
        foreach ($sq as $sor) {
            $alorder = [];
            $sql = DB::table('orders')
                ->select('orders.zipcode as zipcode', 'orders.city as city', 'orders.street as street', 'orders.house_number as house_number', 'orders.other as other', 'orders.name as name', 'orders.mobile_number as mobile_number', 'orders.tax_number as tax_number', 'orders.company_name as company_name', 'orders.company_zipcode as company_zipcode', 'orders.company_city as company_city', 'orders.company_street as company_street', 'orders.company_house_number as company_house_number', 'orders.box_number as box_number', 'states.id as statesid', 'states.status as states', 'orders.created_at as date', 'ordered_products.piece as price', 'ordered_products.gross_amount', 'shipping_methods.price as shippingprice', 'orders.id as ordersid', 'products.file as file', 'products.name as products_name')
                ->join('ordered_products', 'ordered_products.ordersid', '=', 'orders.id')
                ->join('products', 'ordered_products.productsid', '=', 'products.id')
                ->join('states', 'states.id', '=', 'orders.statesid')
                ->join('shipping_methods', 'shipping_methods.id', '=', 'orders.shippingid')
                ->where('orders.userid', '=', Auth::user()->id)
                ->where('orders.id', '=', $sor->id)
                ->get();
            foreach ($sql as $a) {
                $alorder[] = ['zipcode' => $a->zipcode, 'city' => $a->city, 'street' => $a->street, 'house_number' => $a->house_number, 'other' => $a->other, 'name' => $a->name, 'mobile_number' => $a->mobile_number, 'tax_number' => $a->tax_number, 'company_name' => $a->company_name, 'company_zipcode' => $a->company_zipcode, 'company_city' => $a->company_city, 'company_street' => $a->company_street, 'company_house_number' => $a->company_house_number, 'box_number' => $a->box_number, 'statesid' => $a->statesid, 'states' => $a->states, 'date' => $a->date, 'price' => $a->price, 'gross_amount' => $a->gross_amount, 'shippingprice' => $a->shippingprice, 'ordersid' => $a->ordersid, 'file' => $a->file , 'products_name'=>$a->products_name];
            }
            $orders[] = $alorder;
        }

        $layout = Product::layout();
        return view('user.orders', compact('layout', 'orders'));
    }
    public function show()
    {
        $layout = Product::layout();
        return view('user.profil', compact('layout'));
    }
    public function hiteles(Request $request)
    {
        $userid = DB::table('users')
            ->select('id')
            ->where('token', '=', $request->token)
            ->get();
        $update = User::find($userid[0]->id);
        $update->token = '';
        $update->email_verified_at = date("Y-m-d H:i:s");
        $update->update();
        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(1) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as point";
        $negyrandom = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->join('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(8)
            ->get();
        $layout = Product::layout();
        $successful = "Sikeresen aktiválta fiokját!";
        return view('user.successful', compact('layout', 'successful', 'negyrandom'));
    }
}
