<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $layout = Product::layout();
        return view('auth.login', compact('layout'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();


        if (isset(Auth::user()->id)) {
            if (null !== Cookie::get('cart')) {
                if (count(json_decode(Cookie::get('cart')))) {
                    foreach (json_decode(Cookie::get('cart')) as $item) {
                        $sq = DB::table('carts')
                            ->select('*')
                            ->where('userid', '=', Auth::user()->id)
                            ->where('productid', '=', $item->id)
                            ->get();
                        if (count($sq) == 0) {
                            $save = new Cart();
                            $save->userid = Auth::user()->id;
                            $save->productid = $item->id;
                            $save->quantity = $item->quantity;
                            $save->save();
                        }
                    }
                }
            } else {
                $addsql = " round(products.actionprice + ((products.actionprice / 100) * products.vat)) as 'actionprice',  products.vat as 'vat', round(price + ((price / 100) * vat)) as 'oneprice'";
                $sq = DB::table('carts')
                    ->select('products.id as id', 'brands.id as brandid', 'categories.id as categoryid', 'products.name as product_name', 'carts.quantity as quantity', 'products.file as file', 'products.price as taxprice', 'products.actionprice as actiontaxprice', 'products.link as link')
                    ->selectraw($addsql)
                    ->join('products', 'products.id', '=', 'carts.productid')
                    ->join('categories', 'categories.id', '=', 'products.categoryid')
                    ->join('brands', 'brands.id', '=', 'products.brandid')
                    ->where('carts.userid', '=', Auth::user()->id)
                    ->get();
                $cartupdate = [];
                foreach ($sq as $item){
                    $cartupdate[] = ['id' => $item->id, 'actionprice' => $item->actionprice, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $item->actiontaxprice, 'link' => $item->link];   
                }
                Cookie::forget('cart');
                Cookie::queue('cart', json_encode($cartupdate), 60 * 24 * 10);
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
