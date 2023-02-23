<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function hiteles(Request $request)
    {
        $userid = DB::table('users')
            ->select('id')
            ->where('token', '=', $request->token)
            ->get();
        $update = User::find($userid[0]->id);
        $update->token = '';
        $update->email_verified_at =  date("Y-m-d H:i:s");
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
        return view('user.email', compact('layout', 'negyrandom'));
    }
}
