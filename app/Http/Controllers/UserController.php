<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function addtitles()
    {
        ?>
                <form>
        <div class="form-group">
            <label for="name">Név</label>
            <input type="text" class="form-control" id="name" placeholder="Név">
        </div>
        <div class="form-group">
            <label for="id">Irányító szám</label>
            <input type="text" class="form-control" id="id" placeholder="Irányító szám">
        </div>
        <div class="form-group">
            <label for="street">Utca</label>
            <input type="text" class="form-control" id="street" placeholder="Utca">
        </div>
        <div class="form-group">
            <label for="other">Egyéb</label>
            <input type="text" class="form-control" id="other" placeholder="Egyéb">
        </div>
        <div class="form-group">
            <label for="phone">Telefonszám</label>
            <input type="text" class="form-control" id="phone" placeholder="Telefonszám">
        </div>
        <div class="form-group">
            <label for="house">Házszám</label>
            <input type="text" class="form-control" id="house" placeholder="Házszám">
        </div>
        <div class="form-group">
            <label for="tax">Adószám</label>
            <input type="text" class="form-control" id="tax" placeholder="Adószám">
        </div>
        <button type="submit" class="btn btn-primary">Küldés</button>
        </form>
        <?php
}
    public function profiltitles()
    {
        $sql = DB::table('user_adresses')
            ->select('*')
            ->where('userid', '=', Auth::user()->id)
            ->get();
        if (isset($sql[0])) {
            ?>
        <h2>Felvett címek</h2>
        <div class="row">
            <?php
foreach ($sql as $i) {
                ?>
            <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <p class="card-text">Név: <?php echo $i->name ?></p>
                <p class="card-text">Cím: <?php echo $i->zipcode ?> <?php echo $i->city ?> <?php echo $i->street ?> <?php echo $i->house_number ?></p>
                <p class="card-text">Egyéb: <?php echo $i->other ?></p>
                <p class="card-text">Mobil: <?php echo $i->mobile_number ?></p>
                <?php
if ($i->tax_number != "") {
                    ?>
                        <p class="card-text">Adószám: <?php echo $i->tax_number ?></p>
                        <?php
}
                ?>
                <p class="card-text"><button>Módosítás</button></p>
                </div>
            </div>
            </div>
            <?php
}
            ?>
        </div>
        <?php
} else {
            ?>
            <h2>Önnek még nincsen felvett címe</h2>
            <button onclick="addtitles()">Cím felvétele</button>
            <?php
}
    }

    public function profilupdatesave(Request $request)
    {

        $update = User::find(Auth::user()->id);
        if ($request->file()) {
            $request->validate([
                'file' => 'required|mimes:img,png,jpg|max:2048',
            ]);
            $renames = time() . '_' . rand() . $request->file->getClientOriginalName();
            $picture = $request->file('file')->storeAs('users', $renames, 'public');
            $update->file = '/storage/' . $picture;

        } else {
            $update->file = "";
        }
        $update->file = "";
        $update->firstname = $request->firstname;
        $update->lastname = $request->lastname;
        $update->date_of_birth = $request->date_of_birth;
        $update->username = $request->username;
        $update->advertising = $request->advertising;

        $update->update();

    }
    public function profilupdate()
    {
        $layout = Product::layout();
        return view('user.profil', compact('layout'));
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
