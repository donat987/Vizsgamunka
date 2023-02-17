<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function cart()
    {
       ?>
        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Termék neve</th>
                                    <th>Darabár ár</th>
                                    <th>Darabszám</th>
                                    <th>Teljes összeg</th>
                                    <th>Törlés</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach (json_decode(Cookie::get('cart')) as $sor){?>
                                    <tr>
                                        <td><img width="100px" src="<?php echo $sor->file; ?>"</td>
                                        <td class="align-middle"><?php echo $sor->product_name; ?></td>
                                        <td class="align-middle"><?php echo$sor->oneprice; ?> Ft</td>
                                        <td class="align-middle">
                                            <div class="input-group mb-3" style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus"
                                                        id="<?php echo $sor->link; ?>" onclick="kivon(this.id)" name="minus"
                                                        type="button">−</button>
                                                </div>
                                                <input type="text" id="" style="padding: 6px"
                                                    class="form-control text-center border mr-0"
                                                    value="<?php echo $sor->quantity ?>" readonly="e<?php echo $sor->link; ?>"
                                                    id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus"
                                                        id="<?php echo $sor->link; ?>" onclick="hozzaad(this.id)" name="plus"
                                                        type="button">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle"><?php echo $sor->price; ?> Ft</td>
                                        <td class="align-middle"><a><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a>
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
      public function addToCart(Request $request) {
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $quantity = $request->input('quantity');
        $price = $request->input('product_price');
        $file = $request->input('product_file');
        $taxprice = $request->input('product_tax');
        $link = $request->input('product_link');

        $cart = json_decode(Cookie::get('cart'), true);
        $cartupdate = array();
        //dd($cart);
        if (null !== Cookie::get('cart')){
            if (count($cart)) {
                $ok = 0;
                foreach ($cart as $item) {
                    if ($item["id"] == $productId) {
                        $pri = ($item["quantity"] + $quantity) * $item["price"];
                        $cartupdate[] = ['id' => $item["id"],'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] + $quantity, 'price' => $pri, 'file' => $item["file"], 'taxprice' => $item["taxprice"] + $taxprice, 'link' => $item["link"] ];
                        $ok = 1;

                    }
                    else {
                        $cartupdate[] = ['id' => $item["id"],'oneprice' => $item["oneprice"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"], 'price' => $item["price"], 'file' => $item["file"] , 'taxprice' => $item["taxprice"] , 'link' => $item["link"]];
                    }
                }
                if($ok == 0){
                    $cartupdate[] = ['id' => $productId,'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'price' => $price * $quantity, 'file' => $file, 'taxprice' =>  $taxprice, 'link' => $link];
                }
            }
            else{
                $cartupdate[] = ['id' => $productId ,'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'price' => $price * $quantity, 'file' => $file, 'taxprice' =>  $taxprice, 'link' => $link];
            }
        }
        else{
            $cartupdate[] = ['id' => $productId ,'oneprice' => $price, 'product_name' => $productName, 'quantity' => $quantity, 'price' => $price * $quantity, 'file' => $file, 'taxprice' =>  $taxprice, 'link' => $link];
        }
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode($cartupdate), 60 * 24 * 365);
        return redirect()->back()->with('success', 'A termék sikeresen hozzáadva a kosárhoz.');
    }

}

