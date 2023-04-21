<?php

namespace App\Http\Controllers;

use App\Mail\Picking_upMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Ordered_product;
use App\Models\Product;
use Carbon\Carbon;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class PageController extends Controller
{
    public function commentdelete($id)
    {
        DB::table('evaluations')->where('id', $id)->delete();
        return back();
    }
    public function successfulsave($id)
    {
        DB::table('orders')
            ->where('id', '=', $id)
            ->update(['statesid' => 5]);
        return redirect("/admin/teljesitett");
    }
    public function cupondelete($id)
    {
        DB::table('coupons')
            ->where('id', '=', $id)
            ->update(['active' => 0]);
        return back();

    }
    public function actionprices(Request $request)
    {
        if ($request->has("pro")) {
            foreach ($request->input('pro') as $sor) {
                DB::table('products')
                    ->where('id', '=', $sor)
                    ->update(['actionprice' => DB::raw('price * ' . (1 - ($request->input('szaz') / 100)))]);
            }
        }
        if ($request->has("bra")) {
            foreach ($request->input('bra') as $sor) {
                DB::table('products')
                    ->join('brands', 'brands.id', '=', 'products.brandid')
                    ->where('brands.id', '=', $sor)
                    ->update(['actionprice' => DB::raw('price * ' . (1 - ($request->input('szaz') / 100)))]);
            }
        }
        if ($request->has("cat")) {
            foreach ($request->input('cat') as $sor) {
                DB::table('products')
                    ->join('categories', 'categories.id', '=', 'products.categoryid')
                    ->where('categories.id', '=', $sor)
                    ->update(['actionprice' => DB::raw('price * ' . (1 - ($request->input('szaz') / 100)))]);
            }
        }
        return back();
    }
    public function shippingcode(Request $request)
    {
        DB::table('orders')
            ->where('id', '=', $request->id)
            ->update(['box_number' => $request->code]);
        DB::table('orders')
            ->where('id', '=', $request->id)
            ->update(['statesid' => 4]);
        return redirect("/admin/feladas");
    }
    public function actiondelete()
    {
        DB::table('products')
            ->update(['actionprice' => 0]);
        return back();
    }
    public function action()
    {
        $pro = DB::table('products')
            ->select('*')
            ->orderBy('name', 'asc')
            ->get();
        $cat = DB::table('categories')
            ->select('*')
            ->orderBy('subcategory1', 'asc')
            ->get();
        $bra = DB::table('brands')
            ->select('*')
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.action', compact('pro', 'cat', 'bra'));
    }
    public function opinions()
    {
        $sql = DB::table('users')
            ->select('evaluations.comment as comment','evaluations.id as id', 'evaluations.created_at as date', 'users.firstname as firstname', 'users.lastname as lastname', 'evaluations.point as point', 'users.username as username', 'products.name as name', 'users.file as ufile', 'products.file as pfile')
            ->join('evaluations', 'evaluations.userid', '=', 'users.id')
            ->join('products', 'evaluations.productid', '=', 'products.id')
            ->orderBy('evaluations.created_at', 'desc')
            ->paginate(20, ['*'], 'oldal');
        return view('admin.opinions', compact('sql'));
    }
    public function few(Request $request)
    {
        $tep = explode(" ", $request->input('keres'));
        $temp = 0;
        $keres = "";
        for ($i = 0; $i < count($tep); $i++) {
            if ($temp == 0) {
                $keres .= "tags like '%" . $tep[$i] . "%'";
                $temp = 1;
            } else {
                $keres .= "and tags like '%" . $tep[$i] . "%'";
            }
        }
        $beszur = "round(price + ((price / 100) * vat)) as price, round(actionprice + ((actionprice / 100) * vat)) as actionprice";
        $sql = DB::table('products')
            ->select('name', 'quantity', 'file', 'active', 'price as pi', 'link')
            ->selectraw($beszur)
            ->whereraw($keres)
            ->where('quantity', '<', '5')
            ->orderBy('name', 'asc')
            ->paginate(20, ['*'], 'oldal');
        return view('admin.few', compact('sql'));
    }
    public function couponcat(Request $request)
    {
        if ($request->select1 == 1 || $request->select1 == 2 || $request->select1 == 3) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Mettől</label>
                        <input type="date" id="tol" name="tol" required class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Meddig</label>
                        <input type="date" id="ig" name="ig" required class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group input-group-static mb-4">
                        <label>Kuponkód</label>
                        <input type="text" required name="code" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-static mb-4">
                        <label>Kedvezmény összege százalékban</label>
                        <input type="number" required id="percent" name="percent" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-static mb-4">
                        <label>Kedvezmény összege forintban</label>
                        <input type="number" required id="amount" name="amount" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-static mb-4">
                        <label>Hányszor használható fel? (0 korlátlan szám)</label>
                        <input type="number" required name="db" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal">
                        Kupon felvétele
                    </button>
                </div>
                <div class="col-md-3"></div>
            </div>
            <script>
                const tol = document.getElementById("tol");
                const ig = document.getElementById("ig");

                tol.addEventListener("input", function () {
                    if (this.value > ig.value && ig.value) {
                        ig.value = this.value;
                    }
                });

                ig.addEventListener("input", function () {
                    if (this.value < tol.value && tol.value) {
                        tol.value = this.value;
                    }
                });
                const percent = document.getElementById("percent");
                const amount = document.getElementById("amount");

                percent.addEventListener("input", function () {
                    if (this.value) {
                        amount.disabled = true;
                        amount.value = "";
                    } else {
                        amount.disabled = false;
                    }
                });

                amount.addEventListener("input", function () {
                    if (this.value) {
                        percent.disabled = true;
                        percent.value = "";
                    } else {
                        percent.disabled = false;
                    }
                });
            </script>
            <?php
        } elseif ($request->select1 == 4) {
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Mettől</label>
                        <input type="date" id="tol" required name="tol" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group input-group-static mb-4">
                        <label>Meddig</label>
                        <input type="date" id="ig" required name="ig" class="form-control">
                    </div>
                </div>
            </div>
            <?php
            $sql = DB::table('brands')
                ->select('id', 'name')
                ->orderBy('name', 'asc')
                ->get();
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Márka kiválasztása</label>
                        <select size="10" multiple="" required class="form-control pb-4" name="bra[]">
                            <?php foreach ($sql as $sor) { ?>
                                <option value="<?php echo $sor->id ?>"><?php echo $sor->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group input-group-static mb-4">
                            <label>Kuponkód</label>
                            <input type="text" name="code" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-static mb-4">
                            <label>Kedvezmény összege százalékban</label>
                            <input type="number" name="percent" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-static mb-4">
                            <label>Hányszor használható fel? (0 korlátlan szám)</label>
                            <input type="number" name="db" required class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal">
                            Kupon felvétele
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <script>
                    const tol = document.getElementById("tol");
                    const ig = document.getElementById("ig");

                    tol.addEventListener("input", function () {
                        if (this.value > ig.value && ig.value) {
                            ig.value = this.value;
                        }
                    });

                    ig.addEventListener("input", function () {
                        if (this.value < tol.value && tol.value) {
                            tol.value = this.value;
                        }
                    });
                </script>
                <?php

        }
        if ($request->select1 == 5) {
            ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label>Mettől</label>
                            <input type="date" id="tol" required name="tol" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-static mb-4">
                            <label>Meddig</label>
                            <input type="date" id="ig" required name="ig" class="form-control">
                        </div>
                    </div>
                </div>
                <?php
                $sql = DB::table('products')
                    ->select('id', 'name')
                    ->orderBy('name', 'asc')
                    ->get();
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Termékek kiválasztása</label>
                            <select size="10" multiple="" required class="form-control pb-4" name="pro[]">
                                <?php foreach ($sql as $sor) { ?>
                                    <option value="<?php echo $sor->id ?>"><?php echo $sor->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label>Kuponkód</label>
                                <input type="text" name="code" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label>Kedvezmény összege százalékban</label>
                                <input type="number" name="percent" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static mb-4">
                                <label>Hányszor használható fel? (0 korlátlan szám)</label>
                                <input type="number" name="db" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal">
                                Kupon felvétele
                            </button>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <script>
                        const tol = document.getElementById("tol");
                        const ig = document.getElementById("ig");

                        tol.addEventListener("input", function () {
                            if (this.value > ig.value && ig.value) {
                                ig.value = this.value;
                            }
                        });

                        ig.addEventListener("input", function () {
                            if (this.value < tol.value && tol.value) {
                                tol.value = this.value;
                            }
                        });
                    </script>
                    <?php
        }
        if ($request->select1 == 6) {
            ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label>Mettől</label>
                                <input type="date" id="tol" required name="tol" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label>Meddig</label>
                                <input type="date" id="ig" required name="ig" class="form-control">
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql = DB::table('categories')
                        ->select('*')
                        ->orderBy('subcategory1', 'asc')
                        ->get();
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">Kategória kiválasztása</label>
                                <select size="10" multiple="" required class="form-control pb-4" name="cat[]">
                                    <?php foreach ($sql as $sor) { ?>
                                        <option value="<?php echo $sor->id ?>"><?php echo $sor->subcategory ?>-<?php echo $sor->subcategory1 ?>-<?php echo $sor->subcategory2 ?>-<?php echo $sor->subcategory3 ?>-<?php echo $sor->subcategory4 ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group input-group-static mb-4">
                                    <label>Kuponkód</label>
                                    <input type="text" name="code" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group input-group-static mb-4">
                                    <label>Kedvezmény összege százalékban</label>
                                    <input type="number" name="percent" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group input-group-static mb-4">
                                    <label>Hányszor használható fel? (0 korlátlan szám)</label>
                                    <input type="number" name="db" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal">
                                    Kupon felvétele
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <script>
                            const tol = document.getElementById("tol");
                            const ig = document.getElementById("ig");

                            tol.addEventListener("input", function () {
                                if (this.value > ig.value && ig.value) {
                                    ig.value = this.value;
                                }
                            });

                            ig.addEventListener("input", function () {
                                if (this.value < tol.value && tol.value) {
                                    tol.value = this.value;
                                }
                            });
                        </script>
                        <?php
        }

    }
    public function cuponsave(Request $request)
    {
        $save = new Coupon;
        $save->start = $request->tol;
        $save->end = $request->ig;
        $save->active = 1;
        $save->speciesid = $request->cuponcat;
        $save->couponcode = $request->code;
        $save->piece = $request->db;
        if (isset($request->percent)) {
            $save->discount_amount = 0;
            $save->discount_percentage = $request->percent;
        }
        if (isset($request->amount)) {
            $save->discount_amount = $request->amount;
            $save->discount_percentage = 0;
        }
        $save->save();
        if ($request->cuponcat == 4) {
            foreach ($request->input('bra') as $sor) {
                DB::table('coupon_brand')->insert([
                    'couponid' => $save->id,
                    'brandid' => $sor,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        if ($request->cuponcat == 5) {
            foreach ($request->input('pro') as $sor) {
                DB::table('coupon_products')->insert([
                    'couponid' => $save->id,
                    'productid' => $sor,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        if ($request->cuponcat == 6) {
            foreach ($request->input('cat') as $sor) {
                DB::table('coupon_category')->insert([
                    'couponid' => $save->id,
                    'categoryid' => $sor,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        return back();
    }
    public function kuponshow()
    {
        $cup = $sql = DB::table('couponspecies')
            ->select('*')
            ->get();
        $sql = DB::table('coupons')
            ->select('species', 'start', 'end', 'couponcode', 'active', 'coupons.id')
            ->join('couponspecies', 'couponspecies.id', '=', 'coupons.speciesid')
            ->where('coupons.id', '>', 0)
            ->orderBy('active', 'desc')
            ->orderBy('end', 'desc')
            ->paginate(20, ['*'], 'oldal');
        return view('admin.cupon', compact('sql', 'cup'));
    }
    public function product(Request $request)
    {
        $tep = explode(" ", $request->input('keres'));
        $temp = 0;
        $keres = "";
        for ($i = 0; $i < count($tep); $i++) {
            if ($temp == 0) {
                $keres .= "tags like '%" . $tep[$i] . "%'";
                $temp = 1;
            } else {
                $keres .= "and tags like '%" . $tep[$i] . "%'";
            }
        }
        $beszur = "round(price + ((price / 100) * vat)) as price, round(actionprice + ((actionprice / 100) * vat)) as actionprice";
        $sql = DB::table('products')
            ->select('name', 'quantity', 'file', 'active', 'price as pi', 'link')
            ->selectraw($beszur)
            ->whereraw($keres)
            ->orderBy('name', 'asc')
            ->paginate(20, ['*'], 'oldal');
        return view('admin.product', compact('sql'));
    }

    public function adminpage()
    {
        $today = DB::table('ordered_products')
            ->whereDate('created_at', today())
            ->sum('gross_amount');
        $lastday = DB::table('ordered_products')
            ->whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->sum('gross_amount');
        $dayftszaz = intval(((floatval($today) - floatval($lastday)) / floatval($lastday)) * 100);
        $todayp = DB::table('orders')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->count();
        $lastdayp = DB::table('orders')
            ->whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->count();
        $daypszaz = intval(((floatval($todayp) - floatval($lastdayp)) / floatval($lastdayp)) * 100);
        $todayt = DB::table('ordered_products')
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('piece');

        $lasttodayt = DB::table('ordered_products')
            ->whereDate('created_at', now()->subDay()->format('Y-m-d'))
            ->sum('piece');

        $daytszaz = intval(((floatval($todayt) - floatval($lasttodayt)) / floatval($lasttodayt)) * 100);
        $data = DB::connection()->getPdo()->query("SET lc_time_names = 'hu_HU'");
        $dateft = DB::table('ordered_products')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('SUM(gross_amount) AS revenue'))
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 8 MONTH)')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $datedb = DB::table('ordered_products')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS month'), DB::raw('SUM(piece) AS piece'))
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 8 MONTH)')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $datedayft = DB::table('ordered_products')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y.%m.%d') AS date, SUM(gross_amount) AS revenue"))
            ->whereBetween('created_at', [Carbon::now()->subDays(20)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $MonthRevenue = DB::table('ordered_products')
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->sum('gross_amount');
        $lastMonthRevenue = DB::table('ordered_products')
            ->select(DB::raw('SUM(gross_amount) as revenue'))
            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
            ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
            ->first()
            ->revenue;
        $monthbev = intval(((floatval($MonthRevenue) - floatval($lastMonthRevenue)) / floatval($lastMonthRevenue)) * 100);
        $dayft = [];
        foreach ($datedayft as $i) {
            $temp = (explode(".", $i->date));
            if ($temp[1] == "1") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Jan " . $temp[2] . "."];
            } elseif ($temp[1] == "2") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Feb " . $temp[2] . "."];
            } elseif ($temp[1] == "3") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Már " . $temp[2] . "."];
            } elseif ($temp[1] == "4") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Ápr" . $temp[2] . "."];
            } elseif ($temp[1] == "5") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Máj " . $temp[2] . "."];
            } elseif ($temp[1] == "6") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Jún " . $temp[2] . "."];
            } elseif ($temp[1] == "7") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Júl " . $temp[2] . "."];
            } elseif ($temp[1] == "8") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Aug " . $temp[2] . "."];
            } elseif ($temp[1] == "9") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Szept " . $temp[2] . "."];
            } elseif ($temp[1] == "10") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Okt " . $temp[2] . "."];
            } elseif ($temp[1] == "11") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Nov " . $temp[2] . "."];
            } elseif ($temp[1] == "12") {
                $dayft[] = ['revenue' => $i->revenue, 'days' => "Dec " . $temp[2] . "."];
            }
        }
        $monthft = [];
        foreach ($dateft as $i) {
            $temp = (explode("-", $i->month));
            if ($temp[1] == "1") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Jan"];
            } elseif ($temp[1] == "2") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Feb"];
            } elseif ($temp[1] == "3") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Már"];
            } elseif ($temp[1] == "4") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Ápr"];
            } elseif ($temp[1] == "5") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Máj"];
            } elseif ($temp[1] == "6") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Jún"];
            } elseif ($temp[1] == "7") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Júl"];
            } elseif ($temp[1] == "8") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Aug"];
            } elseif ($temp[1] == "9") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Szept"];
            } elseif ($temp[1] == "10") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Okt"];
            } elseif ($temp[1] == "11") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Nov"];
            } elseif ($temp[1] == "12") {
                $monthft[] = ['revenue' => $i->revenue, 'month' => "Dec"];
            }
        }
        return view("admin.desboard", compact('monthft', 'today', 'todayp', 'todayt', 'datedb', 'dayft', 'MonthRevenue', 'monthbev', 'dayftszaz', 'daypszaz', 'daytszaz'));
    }
    public function ordershowsave(Request $request)
    {
        $order = DB::table('ordered_products')
            ->select('*')
            ->where('ordersid', '=', $request->id)
            ->get();
        $temp1 = 0;
        $temp2 = 0;
        foreach ($order as $s) {
            $update = Ordered_product::find($s->id);
            $db = 0;
            if ($request->has("csomagolva")) {
                foreach ($request->input('csomagolva') as $sor) {
                    if ($sor == $s->productsid) {
                        $update->packed = 1;
                        $db = 1;
                        $temp2 += 1;
                    }
                }
            }
            if ($db == 0) {
                $update->packed = 0;
            }
            $temp1 += 1;
            $update->update();
        }
        if ($temp1 == $temp2) {
            $orders = DB::table('ordered_products')->select('name', 'piece', 'gross_amount', 'file')->join('products', 'products.id', '=', 'ordered_products.productsid')->where('ordersid', '=', $request->id)->get();
            $sql = DB::table('orders')
                ->select('orders.id as id', 'orders.name', 'city', 'orders.email as email', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
                ->join('users', 'users.id', '=', 'orders.userid')
                ->join('states', 'states.id', '=', 'orders.statesid')
                ->where('orders.id', '=', $request->id)
                ->get();
            $netto = 0;
            $brutto = 0;
            foreach (DB::table('ordered_products')->select('*')->where('ordersid', '=', $request->id)->get() as $sor) {
                $brutto += round($sor->gross_amount);
                $netto += round($sor->clear_amount);
            }
            $freight_price = 1500;
            $final = $brutto + $freight_price;

            $mailData = [
                'name' => $sql[0]->name,
                'productid' => $request->id,
                'date' => $sql[0]->date,
                'mobil' => $sql[0]->mobile_number,
                'house_number' => $sql[0]->house_number,
                'comment' => $sql[0]->other,
                'zipcode' => $sql[0]->zipcode,
                'city' => $sql[0]->city,
                'street' => $sql[0]->street,
                'tax_number' => $sql[0]->tax_number,
                'company_name' => $sql[0]->company_name,
                'company_zipcode' => $sql[0]->company_zipcode,
                'company_city' => $sql[0]->company_city,
                'company_street' => $sql[0]->company_street,
                'company_house_number' => $sql[0]->company_house_number,
                'taxprice' => $brutto,
                'price' => $netto,
                'finalprice' => $final,
                'freight_price' => $freight_price,
                'status' => "Várakozás a feladásra",
                'order' => $orders,
            ];
            Mail::to($sql[0]->email)->send(new Picking_upMail($mailData));
            $update = Order::find($request->id);
            $update->statesid = 3;
            $update->update();
            return redirect("/admin/csomagolas");
        }
        return back();
    }
    public function ordershow($request)
    {
        Cookie::queue(Cookie::forget('orders'));
        $product = DB::table('ordered_products')
            ->select('*')
            ->join('products', 'products.id', '=', 'ordered_products.productsid')
            ->where('ordered_products.ordersid', '=', $request)
            ->get();
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'orders.email as email', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('orders.id', '=', $request)
            ->where('statesid', '<', 3)
            ->get();


        if (DB::table('orders')->where('statesid', '=', 1)->where('id', '=', $request)->count() == 1) {
            $orders = DB::table('ordered_products')->select('name', 'piece', 'gross_amount', 'file')->join('products', 'products.id', '=', 'ordered_products.productsid')->where('ordersid', '=', $request)->get();
            $netto = 0;
            $brutto = 0;
            foreach (DB::table('ordered_products')->select('*')->where('ordersid', '=', $request)->get() as $sor) {
                $brutto += round($sor->gross_amount);
                $netto += round($sor->clear_amount);
            }
            $freight_price = 1500;
            $final = $brutto + $freight_price;
            $mailData = [
                'name' => $sql[0]->name,
                'productid' => $request,
                'date' => $sql[0]->date,
                'mobil' => $sql[0]->mobile_number,
                'house_number' => $sql[0]->house_number,
                'comment' => $sql[0]->other,
                'zipcode' => $sql[0]->zipcode,
                'city' => $sql[0]->city,
                'street' => $sql[0]->street,
                'tax_number' => $sql[0]->tax_number,
                'company_name' => $sql[0]->company_name,
                'company_zipcode' => $sql[0]->company_zipcode,
                'company_city' => $sql[0]->company_city,
                'company_street' => $sql[0]->company_street,
                'company_house_number' => $sql[0]->company_house_number,
                'taxprice' => $brutto,
                'price' => $netto,
                'finalprice' => $final,
                'freight_price' => $freight_price,
                'status' => "Csomagolás alatt",
                'order' => $orders,
            ];
            Mail::to($sql[0]->email)->send(new Picking_upMail($mailData));
            $update = Order::find($request);
            $update->statesid = 2;
            $update->update();
        }
        return view("admin.ordershow", compact('sql', 'product'));
    }
    public function order()
    {
        Cookie::queue(Cookie::forget('orders'));
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('statesid', '<', 3)
            ->paginate(15, ['*'], 'oldal');
        return view("admin.order", compact('sql'));
    }

    public function sendsave($id)
    {
        $product = DB::table('ordered_products')
            ->select('*')
            ->join('products', 'products.id', '=', 'ordered_products.productsid')
            ->where('ordered_products.ordersid', '=', $id)
            ->get();
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'orders.email as email', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('orders.id', '=', $id)
            ->get();
        return view('admin.sendshow', compact('product', 'sql'));
    }
    public function send()
    {
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('statesid', '=', 3)
            ->paginate(15, ['*'], 'oldal');
        return view("admin.send", compact('sql'));
    }
    public function successful()
    {
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('statesid', '=', 4)
            ->paginate(15, ['*'], 'oldal');
        return view("admin.successful", compact('sql'));
    }
    public function completed()
    {
        $sql = DB::table('orders')
            ->select('orders.id as id', 'orders.name', 'city', 'street', 'house_number', 'zipcode', 'other', 'mobile_number', 'statesid', 'states.status as status', 'states.id as statusid', 'orders.created_at as date', 'tax_number', 'company_name', 'company_zipcode', 'company_city', 'company_street', 'company_house_number')
            ->join('users', 'users.id', '=', 'orders.userid')
            ->join('states', 'states.id', '=', 'orders.statesid')
            ->where('statesid', '>', 4)
            ->paginate(15, ['*'], 'oldal');
        return view("admin.completed", compact('sql'));
    }
    public function index()
    {
        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(point) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as points";
        $negyrandom = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->where('categories.subcategory2', '=', 'Pálinka')
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();

        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(point) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as points";
        $negyrandombor = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->where('categories.subcategory2', '=', 'Bor')
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();

        $sql = "round(products.price + ((products.price / 100) * vat)) as price, COUNT(point) as db,round(actionprice + ((actionprice / 100) * vat)) as actionprice, round(AVG(evaluations.point)*20) as points";
        $negyrandomwiskey = DB::table('products')
            ->select('products.id as id', 'name', 'file', 'link')
            ->selectRaw($sql)
            ->leftJoin('evaluations', 'evaluations.productid', '=', 'products.id')
            ->join('categories', 'categories.id', '=', 'products.categoryid')
            ->where('products.quantity', '>', 0)
            ->where('products.active', '=', 1)
            ->where('categories.subcategory2', '=', 'Whiskey')
            ->groupBy('products.id')
            ->orderByRaw("RAND()")
            ->take(4)
            ->get();

        $layout = Product::layout();
        return view('user.welcome', compact('layout', 'negyrandom', 'negyrandomwiskey', 'negyrandombor'));
    }

    public function addcateg1(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory1')
            ->where('subcategory', '=', $request->select1)
            ->groupBy('subcategory1')
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory1 . "'>";
        }
    }

    public function addcateg2(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory2')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->groupBy('subcategory2')
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory2 . "'>";
        }
    }

    public function addcateg3(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory3')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->groupBy('subcategory3')
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory3 . "'>";
        }
    }

    public function addcateg4(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory4')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->where('subcategory3', '=', $request->select4)
            ->get();
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory4 . "'>";
        }
    }

    public function categ1(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory1')
            ->where('subcategory', '=', $request->select1)
            ->groupBy('subcategory1')
            ->get();

        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory1 . "'>" . $li->subcategory1 . "</option>";
        }
    }

    public function categ2(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory2')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->groupBy('subcategory2')
            ->get();
        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory2 . "'>" . $li->subcategory2 . "</option>";
        }
    }

    public function categ3(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory3')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->groupBy('subcategory3')
            ->get();
        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory3 . "'>" . $li->subcategory3 . "</option>";
        }
    }

    public function categ4(Request $request)
    {
        $cat = DB::table('categories')
            ->select('subcategory4')
            ->where('subcategory', '=', $request->select1)
            ->where('subcategory1', '=', $request->select2)
            ->where('subcategory2', '=', $request->select3)
            ->where('subcategory3', '=', $request->select4)
            ->get();
        echo "<option value=''>Válassz</option>";
        foreach ($cat as $li) {
            echo "<option value='" . $li->subcategory4 . "'>" . $li->subcategory4 . "</option>";
        }
    }

    public function create()
    {
        $category = DB::table('categories')
            ->select('subcategory')
            ->groupBy('subcategory')
            ->get();
        $brand = DB::table('brands')
            ->select('*')
            ->get();
        return view('admin.create', compact('category'), compact('brand'));
    }
}
