<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
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
                            $netto += round(($item->taxprice - (round($item->taxprice / (($szaz / 100) + 1)))) * $item->quantity);
                            $brutto += round(($item->oneprice - (round($item->oneprice / (($szaz / 100) + 1)))) * $item->quantity);
                        } else {
                            $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                            $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                            $netto += round(($item->actiontaxprice - (round($item->actiontaxprice / (($szaz / 100) + 1)))) * $item->quantity);
                            $brutto += round(($item->actionprice - (round($item->actionprice / (($szaz / 100) + 1)))) * $item->quantity);
                        }
                        $termek[] = ['id' => $item->id, 'actionprice' => $actionprice, 'vat' => $item->vat, 'oneprice' => $item->oneprice, 'product_name' => $item->product_name, 'quantity' => $item->quantity, 'file' => $item->file, 'taxprice' => $item->taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $item->link];
                    }
                    $kedvezmeny[] = ['nettokedvezmeny' => round($netto), 'bruttokedvezmeny' => round($brutto)];
                    Cookie::queue('kedvezmenykosar', json_encode($termek), 60);
                    Cookie::queue('kedvezmeny', json_encode($kedvezmeny), 60);
                    echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";
                } else {
                    $afa = 0;
                    $db = 0;
                    foreach (json_decode(Cookie::get('cart')) as $sor) {
                        $afa += $sor->vat;
                        $db += 1;
                    }
                    $netto = round(($sql[0]->ft / ((($afa / $db) / 100) + 1)));
                    $brutto = $sql[0]->ft;
                    $kedvezmeny[] = ['nettokedvezmeny' => $netto, 'bruttokedvezmeny' => $brutto];

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
                        $netto += round(($item->actiontaxprice - (round($item->actiontaxprice / (($szaz / 100) + 1)))) * $item->quantity);
                        $brutto += round(($item->actionprice - (round($item->actionprice / (($szaz / 100) + 1)))) * $item->quantity);
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
                        $netto += round(($item->taxprice - (round($item->taxprice / (($szaz / 100) + 1)))) * $item->quantity);
                        $brutto += round(($item->oneprice - (round($item->oneprice / (($szaz / 100) + 1)))) * $item->quantity);
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
                                $netto += round(($item->taxprice - (round($item->taxprice / (($szaz / 100) + 1)))) * $item->quantity);
                                $brutto += round(($item->oneprice - (round($item->oneprice / (($szaz / 100) + 1)))) * $item->quantity);
                            } else {
                                $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                                $netto += round(($item->actiontaxprice - (round($item->actiontaxprice / (($szaz / 100) + 1)))) * $item->quantity);
                                $brutto += round(($item->actionprice - (round($item->actionprice / (($szaz / 100) + 1)))) * $item->quantity);
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
                                $netto += round(($item->taxprice - (round($item->taxprice / (($szaz / 100) + 1)))) * $item->quantity);
                                $brutto += round(($item->oneprice - (round($item->oneprice / (($szaz / 100) + 1)))) * $item->quantity);
                            } else {
                                $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                                $netto += round(($item->actiontaxprice - (round($item->actiontaxprice / (($szaz / 100) + 1)))) * $item->quantity);
                                $brutto += round(($item->actionprice - (round($item->actionprice / (($szaz / 100) + 1)))) * $item->quantity);
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
                                $netto += round(($item->taxprice - (round($item->taxprice / (($szaz / 100) + 1)))) * $item->quantity);
                                $brutto += round(($item->oneprice - (round($item->oneprice / (($szaz / 100) + 1)))) * $item->quantity);
                            } else {
                                $actionprice = round($item->actionprice / (($szaz / 100) + 1));
                                $actiontaxprice = round($item->actiontaxprice / (($szaz / 100) + 1));
                                $netto += round(($item->actiontaxprice - (round($item->actiontaxprice / (($szaz / 100) + 1)))) * $item->quantity);
                                $brutto += round(($item->actionprice - (round($item->actionprice / (($szaz / 100) + 1)))) * $item->quantity);
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
            echo "<h5 class='text-danger'>Sajnos nem jó kódot adtál meg!</h5>";
        }
    }
    public function cartall()
    {
        $netto = 0;
        $brutto = 0;
        $kedvezmeny = json_decode(Cookie::get('kedvezmeny'));
        print_r($kedvezmeny);
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
        <?php if (null !== Cookie::get('kedvezmeny')) {?>
        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-black">kedvezmény:</span>
            </div>
            <div class="col-md-6 text-right">
                <strong class="text-black"><?php echo $kedvezmeny[0]->bruttokedvezmeny ?> Ft</strong>
            </div>
        </div>
        <?php }?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <span class="text-black">Teljes összeg ÁFA nélkül:</span>
                </div>
            <div class="col-md-6 text-right">
                <?php if (null !== Cookie::get('kedvezmeny')) {?>
                    <strong class="price-old text-black"><?php echo $netto ?> Ft</strong>
                    <strong class="text-black"><?php echo $nettokedvezmeny ?> Ft</strong>
                <?php } else {?>
                    <strong class="text-black"><?php echo $netto ?> Ft</strong>
                <?php }?>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6">
                <span class="text-black">Fizetendő</span>
            </div>
            <div class="col-md-6 text-right">
            <?php if (null !== Cookie::get('kedvezmeny')) {?>
                    <strong class="price-old text-black"><?php echo $brutto ?> Ft</strong>
                    <strong class="text-black"><?php echo $bruttoketvezmeny ?> Ft</strong>
                <?php } else {?>
                    <strong class="text-black"><?php echo $brutto ?> Ft</strong>
                <?php }?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg btn-block" onclick="window.location = '/kosar/veglegesites'">Pénztár</button>
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
                            <th class="text-center">Darabár ár</th>
                            <th class="text-center" style="width: 140px;">Darabszám</th>
                            <th class="text-center">Teljes összeg</th>
                            <th class="text-center">Törlés</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (json_decode(Cookie::get('kedvezmenykosar')) as $sor) {?>
                        <tr>
                            <td><img width="100px" src="<?php echo $sor->file; ?>"</td>
                            <td class="align-middle"><?php echo $sor->product_name; ?></td>
                            <?php if ($sor->actionprice == 0) {?>
                            <td class="align-middle text-center"><?php echo $sor->oneprice; ?> Ft</td>
                            <?php } else {?>
                            <td class="align-middle text-center"><p class="price-old"><?php echo $sor->oneprice; ?></p><?php echo $sor->actionprice; ?> Ft</td>
                            <?php }?>
                            <td class="align-middle text-center">
                                <div class="input-group align-items-center " style="max-width: 120px;">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary js-btn-minus" id="<?php echo $sor->id; ?>" onclick="minus(this.id)" name="minus" type="button">−</button>
                                    </div>
                                    <input type="text" id="" style="padding: 6px" class="form-control text-center border mr-0" value="<?php echo $sor->quantity ?>" readonly="e<?php echo $sor->link; ?>" id="">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary js-btn-plus" id="<?php echo $sor->id; ?>" onclick="plus(this.id)" name="plus" type="button">+</button>
                                    </div>
                                </div>
                            </td>
                            <?php if ($sor->actionprice == 0) {?>
                            <td class="align-middle text-center"><?php echo $sor->oneprice * $sor->quantity; ?> Ft</td>
                            <?php } else {?>
                            <td class="align-middle text-center"><p class="price-old"><?php echo $sor->oneprice * $sor->quantity; ?></p><?php echo $sor->actionprice * $sor->quantity; ?> Ft</td>
                            <?php }?>
                            <td class="align-middle text-center"><a id="<?php echo $sor->id; ?>" onclick="delet(this.id)"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a></td>
                        </tr>
                    <?php }?>
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
                        <th class="text-center">Darabár ár</th>
                        <th class="text-center" style="width: 140px;">Darabszám</th>
                        <th class="text-center">Teljes összeg</th>
                        <th class="text-center">Törlés</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach (json_decode(Cookie::get('cart')) as $sor) {?>
                    <tr>
                        <td><img width="100px" src="<?php echo $sor->file; ?>"</td>
                        <td class="align-middle"><?php echo $sor->product_name; ?></td>
                        <?php if ($sor->actionprice == 0) {?>
                        <td class="align-middle text-center"><?php echo $sor->oneprice; ?> Ft</td>
                        <?php } else {?>
                        <td class="align-middle text-center"><p class="price-old"><?php echo $sor->oneprice; ?></p><?php echo $sor->actionprice; ?> Ft</td>
                        <?php }?>
                        <td class="align-middle text-center">
                            <div class="input-group align-items-center " style="max-width: 120px;">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary js-btn-minus" id="<?php echo $sor->id; ?>" onclick="minus(this.id)" name="minus" type="button">−</button>
                                </div>
                                <input type="text" id="" style="padding: 6px" class="form-control text-center border mr-0" value="<?php echo $sor->quantity ?>" readonly="e<?php echo $sor->link; ?>" id="">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary js-btn-plus" id="<?php echo $sor->id; ?>" onclick="plus(this.id)" name="plus" type="button">+</button>
                                </div>
                            </div>
                        </td>
                        <?php if ($sor->actionprice == 0) {?>
                        <td class="align-middle text-center"><?php echo $sor->oneprice * $sor->quantity; ?> Ft</td>
                        <?php } else {?>
                        <td class="align-middle text-center"><p class="price-old"><?php echo $sor->oneprice * $sor->quantity; ?></p><?php echo $sor->actionprice * $sor->quantity; ?> Ft</td>
                        <?php }?>
                        <td class="align-middle text-center"><a id="<?php echo $sor->id; ?>" onclick="delet(this.id)"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a></td>
                    </tr>
                <?php }?>
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
        return view('user.checkout', compact('layout'));
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
                        if(($item["quantity"] + $quantity) >= 1){
                            $cartupdatecuppon[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"]+ $quantity , 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                        }
                        else{
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
                            if($temp >= 1){
                                $cartupdate[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"]+ $quantity , 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                            }
                            else{
                                $cartupdate[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'brandid' => $item["brandid"], 'categoryid' => $item["categoryid"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] , 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
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
            }elseif($sq[0]->productid == $productId) {
                if(($quantity + $sq[0]->quantity) >= 1){
                    $update = Cart::find($sq[0]->id);
                    $update->quantity = $quantity + $sq[0]->quantity;
                    $update->update();
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
