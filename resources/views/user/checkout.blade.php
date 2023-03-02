@extends('layouts.user')
@section('content')
<div class="site-section">
    <div class="container">
        <form action="koszi.php" title="" method="post">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <h2 class="h3 mb-3 text-black font-heading-serif">Számlázási adatok</h2>
                    <div class="p-3 p-lg-5 border">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_fname" class="text-black">Keresztnév <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="keresztnev" name="keresztnev" required="">
                            </div>
                            <div class="col-md-6">
                                <label for="c_lname" class="text-black">Vezetéknév <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="vezeteknev" name="vezeteknev" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_companyname" class="text-black">Cégnév (opcionális) </label>
                                <input type="text" class="form-control" id="cegnev" name="cegnev">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_companyname" class="text-black">Adószám (opcionális)</label>
                                <input type="text" class="form-control" id="adoszam" name="adoszam">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="c_postal_zip" class="text-black">Cím <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" required="" id="iranyitoszam" name="iranyitoszam" placeholder="Irányítószám">
                            </div>
                            <div class="col-md-6" style="margin : 34px 0px 0px 0px">
                                <input type="text" class="form-control" required="" id="varos" name="varos" placeholder="Város">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" required="" id="utca" name="utca" placeholder="Utca">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" required="" id="hazszam" name="hazszam" placeholder="Házszám, emelet , ajtó (opcionális)">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="c_companyname" class="text-black">Email <span class="text-danger">*</span></label>
                                <input type="text" required="" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="form-group row mb-5">
                            <div class="col-md-6">
                                <label for="c_country" class="text-black">Szolgáltató <span class="text-danger">*</span></label>
                                <select id="szolgaltatoid" required="" name="szolgaltatoid" class="form-control">
                                    <option value="1">Válasszon</option>
                                    <option value="2">3630</option>
                                    <option value="3">3670</option>
                                    <option value="4">3620</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="c_phone" class="text-black">Telefon <span class="text-danger">*</span></label>
                                <input type="text" required="" class="form-control" id="mobil" name="mobil" placeholder="telefonszám">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="c_order_notes" class="text-black">Megjegyzés</label>
                            <textarea name="megjegyzes" id="megjegyzes" cols="30" rows="5" class="form-control" placeholder="Ide írd a megjegyzést..."></textarea>
                        </div>
                    </div>
                </div>

        <div class="col-md-6">
            <div class="row mb-5">

                <div class="col-md-12">
                    <h2 class="h3 mb-3 text-black font-heading-serif">Fizetési mód</h2>
                    <div class="p-3 p-lg-5 border">

                        <div class="border mb-3 p-3 rounded">
                            <h3 class="h6 mb-0"><a class="d-block collapsed" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Utánvétes fizetés | 1500 forint</a></h3>
                            <div class="collapse" id="collapsebank" style="">
                                <div class="py-2 pl-0">
                                  <p class="mb-0" id="para1">A futárszolgálat díja 1500 forintba kerül. Az áru átvételekor kérjük lehetőség szerint a pontos összeget szíveskedjék a futárnak fizetni! Bankkártyával való fizetés lehetséges. Az áru megrendelésétől számított 3 napon belül szállítunk.</p>
                                </div>
                              </div>
                        </div>
                        <div class="border mb-3 p-3 ">
                            <h3 class="h6 mb-0"><a class="d-block collapsed" data-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Utánvétes fizetés | 1500 forint</a></h3>
                            <div class="collapse" id="collapsebank" style="">
                                <div class="py-2 pl-0">
                                    <p class="mb-0" id="para1">A futárszolgálat díja 1500 forintba kerül. Az áru átvételekor kérjük lehetőség szerint a pontos összeget szíveskedjék a futárnak fizetni! Bankkártyával való fizetés lehetséges. Az áru megrendelésétől számított 3 napon belül szállítunk.</p>
                                  </div>
                              </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-12">
                    <h2 class="h3 mb-3 text-black font-heading-serif">A rendelése</h2>
                    <div class="p-3 p-lg-5 border">
                        <table class="table site-block-order-table mb-5">
                            <thead>
                            <tr><th>Termék</th>
                            <th>Ára</th>
                            </tr></thead>
                            <tbody>

                                        <tr>
                                            <td>Alma Pálinka<strong class="mx-2">x</strong> 20</td>
                                            <td>7590 Ft</td>
                                        </tr>

                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Nettó</strong></td>
                                    <td class="text-black">119520 Ft</td>
                                </tr>
                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Bruttó</strong></td>
                                    <td class="text-black"><strong>151800 Ft</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Szállítási díj</strong></td>
                                    <td class="text-black">1500 Ft</td>
                                </tr>
                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Rendelés összesen</strong></td>
                                    <td class="text-black font-weight-bold"><strong>153300 Ft</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button class="btn btn-primary btn-lg btn-block"> Megrendelés</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div></form>
</div>
</div>
<script>
    const para1 = document.getElementById("para1");
const para2 = document.getElementById("para2");

para1.addEventListener("click", function() {
  para1.classList.toggle("selected");
});

para2.addEventListener("click", function() {
  para2.classList.toggle("selected");
});

</script>
@endsection
