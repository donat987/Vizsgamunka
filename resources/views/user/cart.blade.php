@extends('layouts.user')
@section('content')
    <div id="kosar">
        <div class="pb-0">
            <div class="container">
                <div class="row mb-5 justify-content-center">
                    <div class="col-7 section-title text-center mb-5">
                        <h2 class="d-block">Kosár</h2>
                    </div>
                </div>
                <div class="row mb-5">
                    <form class="col-md-12" method="post">
                        <div class="">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Kép</th>
                                        <th class="product-name">Termék neve</th>
                                        <th class="product-ara">Ára</th>
                                        <th class="product-quantity">Db szám</th>
                                        <th class="product-total">Teljes ár</th>
                                        <th class="product-remove">Törlés</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="admin/kepek/termekek/palinka19.png" alt="Image" class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 cart-product-title text-black" style="margin:0% 0% 0% 0%">Alma
                                                Pálinka</h2>
                                        </td>
                                        <td>7590 Ft</td>
                                        <td>
                                            <div class="input-group mb-3" style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus" id="19"
                                                        onclick="kivon(this.id)" name="minus" type="button">−</button>
                                                </div>
                                                <input type="text" style="padding: 6px"
                                                    class="form-control text-center border mr-0" value="3"
                                                    placeholder="" aria-label="Example text with button addon"
                                                    aria-describedby="button-addon1" readonly="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus" id="19"
                                                        onclick="hozzaad(this.id)" name="plus" type="button">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>22770 Ft</td>
                                        <td><button id="palinka19.png" type="button" onclick="torol(this.id)"
                                                class="btn btn-primary height-auto btn-sm">X</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="site-section pt-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <button class="btn btn-primary btn-md btn-block"
                                onclick="window.location.href = 'cart.php'">Kosár frissítése</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary btn-md btn-block"
                                onclick="window.location.href = 'shop.php'">Vásárlás folytatása</button>
                        </div>
                    </div>
                    <form method="post" id="form1" title="" action="modul/kupon.php">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="text-black h4" for="coupon">Kupon</label>
                                <p>Kérlek add meg a kuponkódot.</p>
                            </div>
                            <div class="col-md-8 mb-3 mb-md-0">
                                <input type="text" class="form-control py-3" name="kupon" id="kupon"
                                    placeholder="Kupon">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-md px-4" type="submit" form="form1"
                                    value="Submit">Bevitel</button>
                            </div>

                        </div>
                    </form>
                    <div id="kuponn"></div>
                </div>
                <div id="kosarossz" class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
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
                                    <strong class="text-black">17928 Ft</strong>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Bruttó</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">22770 Ft</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-lg btn-block"
                                        onclick="window.location = 'checkout.php'">Pénztár</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
