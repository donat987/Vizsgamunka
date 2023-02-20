<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cupon(Request $request)
    {
        $kupon = $request->input('cupontext');
        $sql = DB::table('coupons')
            ->select('id', 'discount_amount as ft')
            ->where('active', '=', 1)
            ->where('couponcode', '=', $kupon)
            ->get();
        Cookie::forget('cart');
        $kedvezmeny = 0;
        if (isset($sql[0])) {
            if ($sql[0]->id == '1') {
                $kedvezmeny = $sql[0]->ft;
                echo "<h5 class='text'>Sikeresen aktiváltuk a kuponját!</h5>";
            } elseif ($sql[0]->id == '2') {

            } elseif ($sql[0]->id == '3') {

            } elseif ($sql[0]->id == '4') {

            } elseif ($sql[0]->id == '5') {

            } elseif ($sql[0]->id == '6') {

            } elseif ($sql[0]->id == '7') {

            }
            Cookie::queue('kedvezmeny', $kedvezmeny, 60);
        } else {
            echo "<h5 class='text-danger'>Sajnos nem jó kódot adtál meg!</h5>";
        }

    }
    public function cartall()
    {
        $netto = 0;
        $brutto = 0;
        $kedvezmeny = json_decode(Cookie::get('kedvezmeny'));
        $afa = 0;
        $db = 0;
        foreach (json_decode(Cookie::get('cart')) as $sor) {
            $afa += $sor->vat;
            $db += 1;
            if ($sor->actionprice == 0) {
                $brutto += $sor->oneprice * $sor->quantity;
                $netto += $sor->taxprice * $sor->quantity;
            } else {
                $brutto += $sor->actionprice * $sor->quantity;
                $netto += $sor->actiontaxprice * $sor->quantity;
            }
        }
        if($kedvezmeny != ""){
            $nettokedvezmeny = round($netto - ($kedvezmeny / ((($afa / $db)/100)+1)));
            $bruttoketvezmeny = $brutto - $kedvezmeny;
        }
        ?>
        <div class="row">
            <div class="col-md-12 text-right border-bottom mb-5">
                <h3 class="text-black h4 text-uppercase">Kosár összesen</h3>
            </div>
        </div>
        <?php if($kedvezmeny != ""){?>
        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-black">kedvezmény:</span>
            </div>
            <div class="col-md-6 text-right">
                <strong class="text-black"><?php echo $kedvezmeny ?> Ft</strong>
            </div>
        </div>
        <?php } ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <span class="text-black">Teljes összeg ÁFA nélkül:</span>
                </div>
            <div class="col-md-6 text-right">
                <?php if($kedvezmeny != ""){?>
                    <strong class="price-old text-black"><?php echo $netto ?> Ft</strong>
                    <strong class="text-black"><?php echo $nettokedvezmeny ?> Ft</strong>
                <?php }else{ ?>
                    <strong class="text-black"><?php echo $netto ?> Ft</strong>
                <?php } ?>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-6">
                <span class="text-black">Fizetendő</span>
            </div>
            <div class="col-md-6 text-right">
            <?php if($kedvezmeny != ""){?>
                    <strong class="price-old text-black"><?php echo $brutto ?> Ft</strong>
                    <strong class="text-black"><?php echo $bruttoketvezmeny ?> Ft</strong>
                <?php }else{ ?>
                    <strong class="text-black"><?php echo $brutto ?> Ft</strong>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg btn-block" onclick="window.location = 'checkout.php'">Pénztár</button>
            </div>
        </div>
    <?php
}
    public function cart()
    {
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
                    <td class="align-middle text-center"><p class="price-old"><?php echo $sor->oneprice* $sor->quantity; ?></p><?php echo $sor->actionprice* $sor->quantity; ?> Ft</td>
                    <?php }?>
                    <td class="align-middle text-center"><a id="<?php echo $sor->id; ?>" onclick="delet(this.id)"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
       <?php
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
        $cart = json_decode(Cookie::get('cart'), true);
        $cartupdate = array();
        if (null !== Cookie::get('cart')) {
            if (count($cart)) {
                $ok = 0;
                foreach ($cart as $item) {
                    if ($item["id"] == $productId) {
                        if (!$request->input('del')) {
                            $cartupdate[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] + $quantity, 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                        }
                        $ok = 1;

                    } else {
                        $cartupdate[] = ['id' => $item["id"], 'actionprice' => $item["actionprice"], 'vat' => $item["vat"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'actiontaxprice' => $item["actiontaxprice"], 'link' => $item["link"]];
                    }
                }
                if ($ok == 0) {
                    $cartupdate[] = ['id' => $productId, 'actionprice' => $actionprice, 'vat' => $vat, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $link];
                }
            } else {
                $cartupdate[] = ['id' => $productId, 'actionprice' => $actionprice, 'vat' => $vat, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $link];
            }
        } else {
            $cartupdate[] = ['id' => $productId, 'actionprice' => $actionprice, 'vat' => $vat, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'actiontaxprice' => $actiontaxprice, 'link' => $link];
        }
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode($cartupdate), 60 * 24 * 10);
        if ($request->input('cart')) {
            return response()->json(['success' => true, 'message' => 'A termék hozzáadva a kosárhoz.']);

        } else {
            return redirect()->back()->with('success', 'A termék sikeresen hozzáadva a kosárhoz.');
        }

    }

}
