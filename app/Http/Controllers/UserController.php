<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profilupdate()
    {
        ?>
        <ul class="list-group">
    <li class="list-group-item">
        <div class="form-group">
            <label for="lastname">Vezetéknék:</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo Auth::user()->lastname ?>">
        </div>
    </li>
    <li class="list-group-item">
        <div class="form-group">
            <label for="firstname">Vezetéknék:</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo Auth::user()->firstname ?>">
        </div>
    </li>
    <li class="list-group-item">
        <div class="form-group">
            <label for="date_of_birth">Születési dátum:</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo  Auth::user()->date_of_birth ?>">
        </div>
    </li>
    <li class="list-group-item">
        <div class="form-group">
            <label for="username">Felhasználó név:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo  Auth::user()->username ?>">
        </div>
    </li>
    <li class="list-group-item">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo  Auth::user()->email ?>">
        </div>
    </li>
    <li class="list-group-item">
        <div class="form-group">
            <label for="advertising">Hírdetésre feliratkozott?</label>
            <select class="form-control" id="advertising" name="advertising">
                <option value="1" >igen</option>
                <option value="0">nem</option>
            </select>
        </div>
    </li>
    <li class="list-group-item">
        <div class="custom-file" lang="hu">
            <input type="file" class="custom-file-input" id="customFile"  >
            <label class="custom-file-label" for="customFile">Profilkép</label>
        </div>
    </li>
    <li class="list-group-item">
        <div class="d-flex justify-content-between align-items-center">
            <div></div>
            <button class="btn btn-primary">Mentés</button>
        </div>
    </li>
</ul>
        <?php
    }
    public function data()
    {
        ?>
        <h2>Saját adatok</h2>
            <ul class="list-group">
                <li class="list-group-item">Vezetéknév: <?php echo Auth::user()->lastname?></li>
                <li class="list-group-item">Keresztnév: <?php echo Auth::user()->firstname?></li>
                <li class="list-group-item">Születési dátum: <?php echo Auth::user()->date_of_birth?></li>
                <li class="list-group-item">Felhasználó név: <?php echo Auth::user()->username?></li>
                <li class="list-group-item">Email: <?php echo Auth::user()->email?></li>
                <?php
                if(Auth::user()->advertising == 1){
                    echo '<li class="list-group-item">Hírdetésre feliratkozott? igen</li>';
                }
                else{
                    echo '<li class="list-group-item">Hírdetésre feliratkozott? nem</li>';
                }
                ?>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>Regisztált: <?php echo Auth::user()->created_at?></div>
                        <button class="btn btn-primary" onclick="edit()">Módosítás</button>
                    </div>
                </li>
            </ul>
        <?php
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
        return view('user.email', compact('layout', 'negyrandom'));
    }
}
