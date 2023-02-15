<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
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

        $cart = json_decode(Cookie::get('cart'), true);
        //$cartItem = ['id' => $productId, 'product_name' => $productName, 'quantity' => $quantity];
        $cartupdate = array();
        //dd($cart);
        if (null !== Cookie::get('cart')){
            if (count($cart)) {
                $ok = 0;
                foreach ($cart as $item) {
                    if ($item["id"] == $productId) {
                        $cartupdate[] = ['id' => $item["id"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"] + $quantity];
                        $ok = 1;

                    }
                    else {
                        $cartupdate[] = ['id' => $item["id"], 'product_name' => $item["product_name"], 'quantity' => $item["quantity"]];
                    }
                }
                if($ok == 0){
                    $cartupdate[] = ['id' => $productId, 'product_name' => $productName, 'quantity' => $quantity];
                }
            }
            else{
                $cartupdate[] = ['id' => $productId, 'product_name' => $productName, 'quantity' => $quantity];
            }
        }
        else{
            $cartupdate[] = ['id' => $productId, 'product_name' => $productName, 'quantity' => $quantity];
        }
        Cookie::forget('cart');
        Cookie::queue('cart', json_encode($cartupdate), 60 * 24 * 365);
        return redirect()->back()->with('success', 'A termék sikeresen hozzáadva a kosárhoz.');
    }

}

