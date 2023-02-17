<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function cart()
    {
        echo "hello";
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

