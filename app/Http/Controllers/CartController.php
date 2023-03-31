<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Ordered_product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Mail;

class CartController extends Controller
{
    public function order(Request $request)
    {
        $validated = $request->validate([
            'irányítószám' => 'required|numeric|digits:4',
            'teljes_név' => 'required|min:2|max:50',
            'város' => 'required|min:2|max:50',
            'utca' => 'required|min:2|max:50',
            'házszám' => 'required|min:1|max:7',
            'megjegyzés' => 'max:50',
            'telefonszám' => 'required|numeric',
            'email' => 'required|email',
        ]);
        $oder = new Order;
        $oder->statesid = 1;
        if (Auth::check()) {
            $oder->userid = Auth::user()->id;
        } else {
            $oder->userid = 0;
        }
        $oder->box_number = "";
        $oder->zipcode = $request->irányítószám;
        $oder->name = $request->teljes_név;
        $oder->city = $request->város;
        $oder->street = $request->utca;
        $oder->house_number = $request->házszám;
        if (isset($request->megjegyzés)) {
            $oder->other = $request->megjegyzés;
        } else {
            $oder->other = "";
        }
        $oder->email = $request->email;
        if (isset($request->adószám)) {
            $oder->tax_number = $request->adószám;
        } else {
            $oder->tax_number = "";
        }

        if (isset($request->cégnév)) {
            $oder->company_name = $request->cégnév;
        } else {
            $oder->company_name = "";
        }

        if (isset($request->cég_irányítószám)) {
            $oder->company_zipcode = $request->cég_irányítószám;
        } else {
            $oder->company_zipcode = "";
        }
        if (isset($request->cég_város)) {
            $oder->company_city = $request->cég_város;
        } else {
            $oder->company_city = "";
        }
        if (isset($request->cég_utca)) {
            $oder->company_street = $request->cég_utca;
        } else {
            $oder->company_street = "";
        }
        if (isset($request->cég_házszám)) {
            $oder->company_house_number = $request->cég_házszám;
        } else {
            $oder->company_house_number = "";
        }

        $oder->mobile_number = $request->telefonszám;
        $oder->shippingid = 1;
        if ($request->cookie('kupon')) {
            $sql = DB::table('coupons')
                ->select('id')
                ->where('active', '=', 1)
                ->where('end', '>', date("Y-m-d H:i:s"))
                ->where('start', '<', date("Y-m-d H:i:s"))
                ->where('couponcode', '=', Cookie::get('kupon'))
                ->get();
            $oder->couponid = $sql[0]->id;
        } else {
            $oder->couponid = 0;
        }
        $oder->save();
        $id = $oder->id;
        if (Cookie::get('kedvezmenykosar')) {
            foreach (json_decode(Cookie::get('kedvezmenykosar'), true) as $cart) {
                $oder_pro = new Ordered_product;
                $oder_pro->ordersid = $id;
                $oder_pro->productsid = $cart["id"];
                $oder_pro->piece = $cart["quantity"];
                if ($cart["actiontaxprice"] == 0) {
                    $oder_pro->clear_amount = $cart["taxprice"];
                    $oder_pro->gross_amount = $cart["oneprice"];
                } else {
                    $oder_pro->clear_amount = $cart["actiontaxprice"];
                    $oder_pro->gross_amount = $cart["actionprice"];
                }
                $oder_pro->save();

            }
        } else {
            foreach (json_decode(Cookie::get('cart'), true) as $cart) {
                $oder_pro = new Ordered_product;
                $oder_pro->ordersid = $id;
                $oder_pro->productsid = $cart["id"];
                $oder_pro->piece = $cart["quantity"];
                if ($cart["actiontaxprice"] == 0) {
                    $oder_pro->clear_amount = $cart["taxprice"];
                    $oder_pro->gross_amount = $cart["oneprice"];
                } else {
                    $oder_pro->clear_amount = $cart["actiontaxprice"];
                    $oder_pro->gross_amount = $cart["actionprice"];
                }
                $oder_pro->save();

            }
        }

        if (Auth::check()) {
            $sql = DB::table('carts')
                ->select('id')
                ->where('userid', '=', Auth::user()->id)
                ->get();
            foreach ($sql as $s) {
                $delete = Cart::find($s->id);
                $delete->delete();
            }
        }

        $netto = 0;
        $brutto = 0;
        foreach (json_decode(Cookie::get('finalcart')) as $sor) {
            $brutto += round($sor->brutto);
            $netto += round($sor->netto);
        }
        $freight_price = 1500;
        $final = $brutto + $freight_price;

        $mailData = [
            'name' => $request->teljes_név,
            'productid' => $id,
            'date' => date('Y. m. d.'),
            'mobil' => $request->telefonszám,
            'house_number' => $request->házszám,
            'comment' => $request->megjegyzés,
            'zipcode' => $request->irányítószám,
            'city' => $request->város,
            'street' => $request->utca,
            'tax_number' => $request->adószám,
            'company_name' => $request->cégnév,
            'company_zipcode' => $request->cég_irányítószám,
            'company_city' => $request->cég_város,
            'company_street' => $request->cég_utca,
            'company_house_number' => $request->cég_házszám,
            'taxprice' => $brutto,
            'price' => $netto,
            'finalprice' => $final,
            'freight_price' => $freight_price,
        ];
        Mail::to($request->email)->send(new OrderMail($mailData));
        Cookie::queue(Cookie::forget('cart'));
        Cookie::queue(Cookie::forget('kedvezmeny'));
        Cookie::queue(Cookie::forget('kedvezmenykosar'));
        Cookie::queue(Cookie::forget('kupon'));
        Cookie::queue(Cookie::forget('finalcart'));
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
        $successful = "Sikeres rendelés, köszönjük!";
        return view('user.successful', compact('layout', 'successful', 'negyrandom'));
    }
    public function cupon(Request $request)
    {
        $kupon = $request->input("cupontext");
        Cookie::queue(Cookie::forget('kedvezmeny'));
        Cookie::queue(Cookie::forget('kedvezmenykosar'));
        if ($kupon == "") {
            if (null != Cookie::get('kupon')) {
                $kupon = Cookie::get('kupon');
                Cookie::queue(Cookie::forget('kupon'));
            }
        }
        $sql = DB::table('coupons')
            ->select('id', 'speciesid', 'discount_amount as ft', 'discount_percentage as szazalek')
            ->where('active', '=', 1)
            ->where('end', '>', date("Y-m-d H:i:s"))
            ->where('start', '<', date("Y-m-d H:i:s"))
            ->where('couponcode', '=', $kupon)
            ->get();
        $kedvezmeny = [];
        $netto = 0;
        $brutto = 0;
        if (isset($sql[0])) {
            Cookie::queue('kupon', $kupon, 60);
            if ($sql[0]->speciesid == '1') {
                if ($sql[0]->ft == 0) {
                    $szaz = $sql[0]->szazalek;
                    $termek = [];
                    foreach (json_decode(Cookie::get('cart')) as $item) {
                        $actionprice = 0;
                        $actiontaxprice = 0;
                        if ($item->actionprice == 0) {
                            $actionprice = round($item->oneprice / (($szaz / 100) + 1));
                            $actiontaxprice = round($item->taxprice / (($szaz / 100) + 1));
                            $netto += round(($item->taxprice - $actiontaxprice) * $item->quantity);
                            $brutto += round(($item->oneprice - $actionprice) * $item->quantity);
                        } else {
                            $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                            $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                            $netto += round(($item->actiontaxprice - $actiontaxprice) * $item->quantity);
                            $brutto += round(($item->actionprice - $actionprice) * $item->quantity);
                        }
                        $termek[] = ['id' => $item->id, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                    }
                    $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                    Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                    Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                    echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";
                } else {
                    $termek = [];
                    $db = 0;
                    foreach (json_decode(Cookie::get('cart')) as $item) {
                        $db += 1;
                    }
                    $szaz = $sql[0]->ft;
                    foreach (json_decode(Cookie::get('cart')) as $item) {
                        $actionprice = 0;
                        $actiontaxprice = 0;
                        $csokk = $szaz / ($item->vat / 100 + 1);
                        if ($item->actionprice == 0) {
                            $actionprice = round($item->oneprice - (($szaz / $db) / $item->quantity));
                            $actiontaxprice = round($item->taxprice - (($csokk / $db) / $item->quantity));
                            $netto += round(($item->taxprice - $actiontaxprice) * $item->quantity);
                            $brutto += round(($item->oneprice - $actionprice) * $item->quantity);
                        } else {
                            $actionprice = round($item->actionprice - (($szaz / $db) / $item->quantity));
                            $actiontaxprice = round($item->actiontaxprice - (($csokk / $db) / $item->quantity));
                            $netto += round(($item->actiontaxprice - $actiontaxprice) * $item->quantity);
                            $brutto += round(($item->actionprice - $actionprice) * $item->quantity);
                        }
                        $termek[] = ['id' => $item->id, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                    }
                    $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                    Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                    Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                    echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";
                }
            } elseif ($sql[0]->speciesid == '2') {
                $szaz = $sql[0]->szazalek;
                $termek = [];
                foreach (json_decode(Cookie::get('cart')) as $item) {
                    $actionprice = 0;
                    $actiontaxprice = 0;
                    if ($item->actionprice != 0) {
                        $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                        $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                        $netto += round(($item->actiontaxprice - $actiontaxprice) * $item->quantity);
                        $brutto += round(($item->actionprice - $actionprice) * $item->quantity);
                    }
                    $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                }
                $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";

            } elseif ($sql[0]->speciesid == '3') {
                $szaz = $sql[0]->szazalek;
                $termek = [];
                foreach (json_decode(Cookie::get('cart')) as $item) {
                    $actionprice = 0;
                    $actiontaxprice = 0;
                    if ($item->actionprice == 0) {
                        $actionprice = round($item->oneprice / (($szaz / 100) + 1));
                        $actiontaxprice = round($item->taxprice / (($szaz / 100) + 1));
                        $netto += round(($item->taxprice - $actiontaxprice) * $item->quantity);
                        $brutto += round(($item->oneprice - $actionprice) * $item->quantity);
                    }
                    $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                }
                $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";

            } elseif ($sql[0]->speciesid == '4') {
                $sq = DB::table('coupons')
                    ->select('brandid')
                    ->join('coupon_brand', 'coupon_brand.couponid', '=', 'coupons.id')
                    ->where('active', '=', 1)
                    ->where('end', '>', date("Y-m-d H:i:s"))
                    ->where('start', '<', date("Y-m-d H:i:s"))
                    ->where('couponcode', '=', $kupon)
                    ->get();
                $szaz = $sql[0]->szazalek;
                $termek = [];
                foreach (json_decode(Cookie::get('cart')) as $item) {
                    $actionprice = 0;
                    $actiontaxprice = 0;
                    $vanbenne = false;
                    foreach ($sq as $sor) {
                        if ($item->brandid == $sor->brandid) {
                            $vanbenne = true;
                            if ($item->actionprice == 0) {
                                $actionprice = round($item->oneprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->taxprice / (($szaz / 100) + 1));
                                $netto += round(($item->taxprice - $actiontaxprice) * $item->quantity);
                                $brutto += round(($item->oneprice - $actionprice) * $item->quantity);
                            } else {
                                $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                                $netto += round(($item->actiontaxprice - $actiontaxprice) * $item->quantity);
                                $brutto += round(($item->actionprice - $actionprice) * $item->quantity);
                            }
                        }
                    }
                    if ($vanbenne == true) {
                        $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                    } else {
                        $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $item->actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $item->actiontaxprice, 'link' => $item->link];
                    }

                }
                $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";
            } elseif ($sql[0]->speciesid == '5') {
                $sq = DB::table('coupons')
                    ->select('productid')
                    ->join('coupon_products', 'coupon_products.couponid', '=', 'coupons.id')
                    ->where('active', '=', 1)
                    ->where('end', '>', date("Y-m-d H:i:s"))
                    ->where('start', '<', date("Y-m-d H:i:s"))
                    ->where('couponcode', '=', $kupon)
                    ->get();
                $szaz = $sql[0]->szazalek;
                $termek = [];
                foreach (json_decode(Cookie::get('cart')) as $item) {
                    $actionprice = 0;
                    $actiontaxprice = 0;
                    $vanbenne = false;
                    foreach ($sq as $sor) {
                        if ($item->id == $sor->productid) {
                            $vanbenne = true;
                            if ($item->actionprice == 0) {
                                $actionprice = round($item->oneprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->taxprice / (($szaz / 100) + 1));
                                $netto += round(($item->taxprice - $actiontaxprice) * $item->quantity);
                                $brutto += round(($item->oneprice - $actionprice) * $item->quantity);
                            } else {
                                $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                                $netto += round(($item->actiontaxprice - $actiontaxprice) * $item->quantity);
                                $brutto += round(($item->actionprice - $actionprice) * $item->quantity);
                            }
                        }
                    }
                    if ($vanbenne == true) {
                        $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                    } else {
                        $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $item->actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $item->actiontaxprice, 'link' => $item->link];
                    }

                }
                $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";

            } elseif ($sql[0]->speciesid == '6') {
                $sq = DB::table('coupons')
                    ->select('categoryid')
                    ->join('coupon_category', 'coupon_category.couponid', '=', 'coupons.id')
                    ->where('active', '=', 1)
                    ->where('end', '>', date("Y-m-d H:i:s"))
                    ->where('start', '<', date("Y-m-d H:i:s"))
                    ->where('couponcode', '=', $kupon)
                    ->get();
                $szaz = $sql[0]->szazalek;
                $termek = [];
                foreach (json_decode(Cookie::get('cart')) as $item) {
                    $actionprice = 0;
                    $actiontaxprice = 0;
                    $vanbenne = false;
                    foreach ($sq as $sor) {
                        if ($item->categoryid == $sor->categoryid) {
                            $vanbenne = true;
                            if ($item->actionprice == 0) {
                                $actionprice = round($item->oneprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->taxprice / (($szaz / 100) + 1));
                                $netto += round(($item->taxprice - $actiontaxprice) * $item->quantity);
                                $brutto += round(($item->oneprice - $actionprice) * $item->quantity);
                            } else {
                                $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                                $netto += round(($item->actiontaxprice - $actiontaxprice) * $item->quantity);
                                $brutto += round(($item->actionprice - $actionprice) * $item->quantity);
                            }
                        }
                    }
                    if ($vanbenne == true) {
                        $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                    } else {
                        $termek[] = ['id' => $item->id, 'brandid' => $item->brandid, 'categoryid' => $item->categoryid, 'actionprice' => $item->actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $item->actiontaxprice, 'link' => $item->link];
                    }

                }
                $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";

            } else {
                echo "<h5 class='text-danger'>Hiba lépett fel!</h5>";
            }

        } else {
            Cookie::queue(Cookie::forget('kupon'));
            echo "<h5 class='text-danger'>Sajnos nem jó kódot adtál meg!</h5>";
        }
    }
    public function cartall()
    {
        $netto = 0;
        $brutto = 0;
        $kedvezmeny = json_decode(Cookie::get('kedvezmeny'));
        foreach (json_decode(Cookie::get('cart')) as $sor) {
            if ($sor->actionprice == 0) {
                $brutto += round($sor->oneprice * $sor->quantity);
                $netto += round($sor->taxprice * $sor->quantity);
            } else {
                $brutto += round($sor->actionprice * $sor->quantity);
                $netto += round($sor->actiontaxprice * $sor->quantity);
            }
        }
        if (null !== Cookie::get('kedvezmeny')) {
            $nettokedvezmeny = round($netto - $kedvezmeny[0]->nettokedvezmeny);
            $bruttoketvezmeny = round($brutto - $kedvezmeny[0]->bruttokedvezmeny);
        }
        ?>
        <div class="row">
            <div class="col-md-12 text-right border-bottom mb-5">
                <h3 class="text-black h4 text-uppercase">Kosár összesen</h3>
            </div>
        </div>
        <?php if (null !== Cookie::get('kedvezmeny')) { ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <span class="text-black">kedvezmény:</span>
                </div>
                <div class="col-md-6 text-right">
                    <strong class="text-black">
                        <?php echo $kedvezmeny[0]->bruttokedvezmeny ?> Ft
                    </strong>
                </div>
            </div>
        <?php } ?>
        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-black">Teljes összeg ÁFA nélkül:</span>
            </div>
            <div class="col-md-6 text-right">
                <?php if (null !== Cookie::get('kedvezmeny')) { ?>
                    <strong class="price-old text-black">
                        <?php echo $netto ?> Ft
                    </strong>
                    <strong class="text-black">
                        <?php echo $nettokedvezmeny ?> Ft
                    </strong>
                <?php } else { ?>
                    <strong class="text-black">
                        <?php echo $netto ?> Ft
                    </strong>
                <?php } ?>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6">
                <span class="text-black">Fizetendő</span>
            </div>
            <div class="col-md-6 text-right">
                <?php if (null !== Cookie::get('kedvezmeny')) { ?>
                    <strong class="price-old text-black">
                        <?php echo $brutto ?> Ft
                    </strong>
                    <strong class="text-black">
                        <?php echo $bruttoketvezmeny ?> Ft
                    </strong>
                <?php } else { ?>
                    <strong class="text-black">
                        <?php echo $brutto ?> Ft
                    </strong>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg btn-block"
                    onclick="window.location = '/kosar/veglegesites'">Pénztár</button>
            </div>
        </div>

        <?php
    }
    public function cart()
    {
        if (null !== Cookie::get('kedvezmenykosar')) {
            if (count(json_decode(Cookie::get('kedvezmenykosar')))) {
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Termék neve</th>
                            <th class="text-center">Darab ár</th>
                            <th class="text-center" style="width: 140px;">Darabszám</th>
                            <th class="text-center">Teljes összeg</th>
                            <th class="text-center">Törlés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (json_decode(Cookie::get('kedvezmenykosar')) as $sor) { ?>
                            <tr>
                                <td><img width="100px" src="<?php echo $sor->file; ?>" </td>
                                <td class="align-middle">
                                    <?php echo $sor->product_name; ?>
                                </td>
                                <?php if ($sor->actionprice == 0) { ?>
                                    <td class="align-middle text-center">
                                        <?php echo $sor->oneprice; ?> Ft
                                    </td>
                                <?php } else { ?>
                                    <td class="align-middle text-center">
                                        <p class="price-old">
                                            <?php echo $sor->oneprice; ?>
                                        </p>
                                        <?php echo $sor->actionprice; ?> Ft
                                    </td>
                                <?php } ?>
                                <td class="align-middle text-center">
                                    <div class="input-group align-items-center " style="max-width: 120px;">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-primary js-btn-minus" id="<?php echo $sor->id; ?>"
                                                onclick="minus(this.id)" name="minus" type="button">−</button>
                                        </div>
                                        <input type="text" id="" style="padding: 6px" class="form-control text-center border mr-0"
                                            value="<?php echo $sor->quantity ?>" readonly="e<?php echo $sor->link; ?>" id="">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary js-btn-plus" id="<?php echo $sor->id; ?>"
                                                onclick="plus(this.id)" name="plus" type="button">+</button>
                                        </div>
                                    </div>
                                </td>
                                <?php if ($sor->actionprice == 0) { ?>
                                    <td class="align-middle text-center">
                                        <?php echo $sor->oneprice * $sor->quantity; ?> Ft
                                    </td>
                                <?php } else { ?>
                                    <td class="align-middle text-center">
                                        <p class="price-old">
                                            <?php echo $sor->oneprice * $sor->quantity; ?>
                                        </p>
                                        <?php echo $sor->actionprice * $sor->quantity; ?> Ft
                                    </td>
                                <?php } ?>
                                <td class="align-middle text-center"><a id="<?php echo $sor->id; ?>" onclick="delet(this.id)"><i
                                            class="fa fa-trash fa-2x" aria-hidden="true"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
            }
        } else {
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Termék neve</th>
                        <th class="text-center">Darabs ár</th>
                        <th class="text-center" style="width: 140px;">Darabszám</th>
                        <th class="text-center">Teljes összeg</th>
                        <th class="text-center">Törlés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (json_decode(Cookie::get('cart')) as $sor) { ?>
                        <tr>
                            <td><img width="100px" src="<?php echo $sor->file; ?>" </td>
                            <td class="align-middle">
                                <?php echo $sor->product_name; ?>
                            </td>
                            <?php if ($sor->actionprice == 0) { ?>
                                <td class="align-middle text-center">
                                    <?php echo $sor->oneprice; ?> Ft
                                </td>
                            <?php } else { ?>
                                <td class="align-middle text-center">
                                    <p class="price-old">
                                        <?php echo $sor->oneprice; ?>
                                    </p>
                                    <?php echo $sor->actionprice; ?> Ft
                                </td>
                            <?php } ?>
                            <td class="align-middle text-center">
                                <div class="input-group align-items-center " style="max-width: 120px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary js-btn-minus" id="<?php echo $sor->id; ?>"
                                            onclick="minus(this.id)" name="minus" type="button">−</button>
                                    </div>
                                    <input type="text" id="" style="padding: 6px" class="form-control text-center border mr-0"
                                        value="<?php echo $sor->quantity ?>" readonly="e<?php echo $sor->link; ?>" id="">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary js-btn-plus" id="<?php echo $sor->id; ?>"
                                            onclick="plus(this.id)" name="plus" type="button">+</button>
                                    </div>
                                </div>
                            </td>
                            <?php if ($sor->actionprice == 0) { ?>
                                <td class="align-middle text-center">
                                    <?php echo $sor->oneprice * $sor->quantity; ?> Ft
                                </td>
                            <?php } else { ?>
                                <td class="align-middle text-center">
                                    <p class="price-old">
                                        <?php echo $sor->oneprice * $sor->quantity; ?>
                                    </p>
                                    <?php echo $sor->actionprice * $sor->quantity; ?> Ft
                                </td>
                            <?php } ?>
                            <td class="align-middle text-center"><a id="<?php echo $sor->id; ?>" onclick="delet(this.id)"><i
                                        class="fa fa-trash fa-2x" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
        }
    }

    public function delet()
    {
        Cookie::queue(Cookie::forget('cart'));
        return redirect()->back();
    }
    public function checkout()
    {
        $layout = Product::layout();
        $cart = [];
        Cookie::queue(Cookie::forget('finalcart'));
        if (null !== Cookie::get('kedvezmenykosar')) {
            if (count(json_decode(Cookie::get('kedvezmenykosar')))) {
                $netto = 0;
                $brutto = 0;
                foreach (json_decode(Cookie::get('kedvezmenykosar')) as $sor) {
                    $price = 0;
                    $b = 0;
                    $n = 0;
                    if ($sor->actionprice != 0) {
                        $price = $sor->actionprice * $sor->quantity;
                        $brutto += round($sor->actionprice * $sor->quantity);
                        $netto += round($sor->actiontaxprice * $sor->quantity);
                        $b = round($sor->actionprice * $sor->quantity);
                        $n = round($sor->actiontaxprice * $sor->quantity);
                    } else {
                        $price = $sor->oneprice * $sor->quantity;
                        $brutto += round($sor->oneprice * $sor->quantity);
                        $netto += round($sor->taxprice * $sor->quantity);
                        $b = round($sor->oneprice * $sor->quantity);
                        $n = round($sor->taxprice * $sor->quantity);
                    }
                    $cart[] = ['name' => $sor->product_name, 'quantity' => $sor->quantity, 'price' => $price, 'brutto' => $b, 'netto' => $n, 'file' => $sor->file];
                }
                $allp = $brutto + 1500;
                Cookie::queue('finalcart', json_encode($cart), 60);
                if (Auth::check()) {
                    $sql = DB::table('user_adresses')
                        ->select('*')
                        ->where('userid', '=', Auth::user()->id)
                        ->get();
                    return view('user.checkout', compact('layout', 'cart', 'netto', 'brutto', 'allp', 'sql'));
                } else {
                    return view('user.checkout', compact('layout', 'cart', 'netto', 'brutto', 'allp'));
                }
            } else {
                return redirect('/kosar');
            }
        } elseif (null !== Cookie::get('cart')) {
            if (count(json_decode(Cookie::get('cart')))) {
                $netto = 0;
                $brutto = 0;
                foreach (json_decode(Cookie::get('cart')) as $sor) {
                    $price = 0;
                    $b = 0;
                    $n = 0;
                    if ($sor->actionprice != 0) {
                        $price = $sor->actionprice * $sor->quantity;
                        $brutto += round($sor->actionprice * $sor->quantity);
                        $netto += round($sor->actiontaxprice * $sor->quantity);
                        $b = round($sor->actionprice * $sor->quantity);
                        $n = round($sor->actiontaxprice * $sor->quantity);
                    } else {
                        $price = $sor->oneprice * $sor->quantity;
                        $brutto += round($sor->oneprice * $sor->quantity);
                        $netto += round($sor->taxprice * $sor->quantity);
                        $b = round($sor->oneprice * $sor->quantity);
                        $n = round($sor->taxprice * $sor->quantity);
                    }
                    $cart[] = ['name' => $sor->product_name, 'quantity' => $sor->quantity, 'price' => $price, 'brutto' => $b, 'netto' => $n, 'file' => $sor->file];
                }
                $allp = $brutto + 1500;
                Cookie::queue('finalcart', json_encode($cart), 60);
                if (Auth::check()) {
                    $sql = DB::table('user_adresses')
                        ->select('*')
                        ->where('userid', '=', Auth::user()->id)
                        ->get();
                    return view('user.checkout', compact('layout', 'cart', 'netto', 'brutto', 'allp', 'sql'));
                } else {
                    return view('user.checkout', compact('layout', 'cart', 'netto', 'brutto', 'allp'));
                }
            } else {
                return redirect('/kosar');
            }

        } else {
            return redirect('/kosar');
        }
    }

    public function show()
    {
        $layout = Product::layout();
        return view('user.cart', compact('layout'));
    }

    // a kosár tartalmának hozzáadása egy termékhez
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $quantity = $request->input('quantity');
        $price = $request->input('product_price');
        $file = $request->input('product_file');
        $taxprice = $request->input('product_tax');
        $actiontaxprice = $request->input('product_actiontax');
        $link = $request->input('product_link');
        $actionprice = $request->input('product_actionprice');
        $vat = $request->input('product_vat');
        $brandid = $request->input('product_brandid');
        $categoryid = $request->input('product_categid');
        $cart = json_decode(Cookie::get('cart'), true);
        $cartcupon = json_decode(Cookie::get('kedvezmenykosar'), true);
        $cartupdate = [];
        $cartupdatecuppon = [];
        if (null !== Cookie::get('kedvezmenykosar')) {
            foreach ($cartcupon as $item) {
                if ($item["id"] == $productId) {
                    if (!$request->input('del')) {
                        if (($item["quantity"] + $quantity) >= 1) {
                            $cartupdatecuppon[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] + $quantity, 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                        } else {
                            $cartupdatecuppon[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                        }
                    }
                } else {
                    $cartupdatecuppon[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                }
            }
            Cookie::queue(Cookie::forget('kedvezmenykosar'));
            Cookie::queue('kedvezmenykosar', json_encode($cartupdatecuppon), 60);
        }
        if (null !== Cookie::get('cart')) {
            if (count($cart)) {
                $ok = 0;
                foreach ($cart as $item) {
                    if ($item["id"] == $productId) {
                        if (!$request->input('del')) {
                            $temp = $item["quantity"] + $quantity;
                            if ($temp >= 1) {
                                $cartupdate[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] + $quantity, 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                            } else {
                                $cartupdate[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                            }
                        }
                        $ok = 1;

                    } else {
                        $cartupdate[] = ['id' => $item["id"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'actionprice' => $item["actionprice"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                    }
                }
                if ($ok == 0) {
                    $cartupdate[] = ['id' => $productId, 'brandid' => $brandid, 'categoryid' => $categoryid, 'actionprice' => $actionprice, 'vat' => $vat, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $link];
                }
            } else {
                $cartupdate[] = ['id' => $productId, 'brandid' => $brandid, 'categoryid' => $categoryid, 'actionprice' => $actionprice, 'vat' => $vat, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $link];
            }
        } else {
            $cartupdate[] = ['id' => $productId, 'brandid' => $brandid, 'categoryid' => $categoryid, 'actionprice' => $actionprice, 'vat' => $vat, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $link];
        }
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode($cartupdate), 60 * 24 * 10);
        if (isset(Auth::user()->id)) {
            $sq = DB::table('carts')
                ->select('*')
                ->where('userid', '=', Auth::user()->id)
                ->where('productid', '=', $productId)
                ->get();
            if (count($sq) == 0) {
                $save = new Cart();
                $save->userid = Auth::user()->id;
                $save->productid = $productId;
                $save->quantity = $quantity;
                $save->save();
            } elseif ($sq[0]->productid == $productId) {
                if (($quantity + $sq[0]->quantity) >= 1) {
                    if ($request->input('del')) {
                        $del = Cart::find($sq[0]->id);
                        $del->delete();
                    } else {
                        $update = Cart::find($sq[0]->id);
                        $update->quantity = $quantity + $sq[0]->quantity;
                        $update->update();
                    }
                }
            }
        }
        if ($request->input('cart')) {
            return response()->json(['success' => true, 'message' => 'A termék hozzáadva a kosárhoz.']);

        } else {
            return redirect()->back()->with('success', 'A termék sikeresen hozzáadva a kosárhoz.');
        }

    }

}
