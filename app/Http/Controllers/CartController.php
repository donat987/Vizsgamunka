<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function cartall()
    {
        $netto = 0;
        $brutto = 0;
        foreach (json_decode(Cookie::get('cart')) as $sor){
            $brutto += $sor->oneprice * $sor->quantity;
            $netto += $sor->taxprice * $sor->quantity;
        }

        ?>
        <div class="row">
                                            <div class="col-md-12 text-right border-bottom mb-5">
                                                <h3 class="text-black h4 text-uppercase">KOSÁR ÖSSZESEN</h3>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <span class="text-black">Nettó</span>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <strong class="text-black"><?php echo $netto ?> Ft</strong>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-6">
                                                <span class="text-black">Bruttó</span>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <strong class="text-black"><?php echo $brutto ?> Ft</strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary btn-lg btn-block"
                                                    onclick="window.location = 'checkout.php'">Pénztár</button>
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
                                        <td class="align-middle text-center"><?php echo $sor->oneprice; ?> Ft</td>
                                        <td class="align-middle text-center">
                                            <div class="input-group align-items-center " style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus"
                                                        id="<?php echo $sor->id; ?>" onclick="minus(this.id)" name="minus"
                                                        type="button">−</button>
                                                </div>
                                                <input type="text" id="" style="padding: 6px"
                                                    class="form-control text-center border mr-0"
                                                    value="<?php echo $sor->quantity ?>" readonly="e<?php echo $sor->link; ?>"
                                                    id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus"
                                                        id="<?php echo $sor->id; ?>" onclick="plus(this.id)" name="plus"
                                                        type="button">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center"><?php echo $sor->oneprice * $sor->quantity; ?> Ft</td>
                                        <td class="align-middle text-center"><a id="<?php echo $sor->id; ?>" onclick="delet(this.id)"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
                                        </td>
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
        $link = $request->input('product_link');
        $cart = json_decode(Cookie::get('cart'), true);
        $cartupdate = array();
        if (null !== Cookie::get('cart')) {
            if (count($cart)) {
                $ok = 0;
                foreach ($cart as $item) {
                    if ($item["id"] == $productId) {
                        if (!$request->input('del')) {
                            $cartupdate[] = ['id' => $item["id"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] + $quantity, 'file' => $item["file"], 'taxprice' => $item["taxprice"] + $taxprice, 'link' => $item["link"]];
                        }
                        $ok = 1;

                    } else {
                        $cartupdate[] = ['id' => $item["id"], 'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'file' => $item["file"], 'taxprice' => $item["taxprice"], 'link' => $item["link"]];
                    }
                }
                if ($ok == 0) {
                    $cartupdate[] = ['id' => $productId, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'link' => $link];
                }
            } else {
                $cartupdate[] = ['id' => $productId, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'link' => $link];
            }
        } else {
            $cartupdate[] = ['id' => $productId, 'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'file' => $file, 'taxprice' => $taxprice, 'link' => $link];
        }
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode($cartupdate), 60 * 24 * 365);
        if ($request->input('cart')) {
            return response()->json(['success' => true, 'message' => 'A termék hozzáadva a kosárhoz.']);

        } else {
            return redirect()->back()->with('success', 'A termék sikeresen hozzáadva a kosárhoz.');
        }

    }

}
