@extends('layouts.user')
@section('content')
    <section class="section-content">
        <div class="container mb-5 mt-5">
            <form action="koszi.php" title="" method="post">
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black font-heading-serif">Számlázási adatok</h2>
                        @php
                            $db = 0;
                        @endphp
                        @foreach ($sql as $sor)
                            <div class="p-3 px-5 border mb-3">
                                <div class="form-check d-flex align-items-center">
                                    <input class="form-check-input me-3" type="radio" value="{{ $sor->id }}"
                                        id="valasztas{{ $sor->id }}" onclick="valsztas({{ $db }});"
                                        name="valasztas" for="radio{{ $sor->id }}">
                                    <label class="form-check-label" for="radio{{ $sor->id }}">
                                        <div class="col-sm-12">
                                            <p class="mb-0">Teljes név: {{ $sor->name }}</p>
                                            <p class="mb-0">Cím: {{ $sor->zipcode }} {{ $sor->city }}
                                                {{ $sor->street }} {{ $sor->house_number }}</p>
                                            <p class="mb-0">Telefonszám: {{ $sor->mobile_number }}</p>
                                            <p class="mb-0">Egyéb: {{ $sor->other }}</p>
                                            @if ($sor->tax_number != '')
                                                {
                                                <p class="mb-0">Egyéb: {{ $sor->tax_number }}</p>
                                                }
                                            @endif
                                            @if ($sor->company_name != '')
                                                {
                                                <p class="mb-0">Egyéb: {{ $sor->company_name }}</p>
                                                }
                                            @endif
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @php
                                $db += 1;
                            @endphp
                        @endforeach
                        <script>
                            function valsztas(p) {
                                var sql = JSON.parse('{!! addslashes(json_encode($sql)) !!}');
                                var email = "{{Auth::user()->email}}";
                                document.getElementById("teljes_név").value = sql[p].name;
                                document.getElementById("cégnév").value = sql[p].company_name;
                                document.getElementById("adószám").value = sql[p].tax_number;
                                document.getElementById("irányítószám").value = sql[p].zipcode;
                                document.getElementById("város").value = sql[p].city;
                                document.getElementById("utca").value = sql[p].street;
                                document.getElementById("házszám").value = sql[p].house_number;
                                document.getElementById("email").value = email;
                                document.getElementById("telefonszám").value = sql[p].mobile_number;
                                document.getElementById("megjegyzés").value = sql[p].other;
                            }
                        </script>
                        <div class="p-3 px-5 border mb-3">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="teljes_név" class="text-black">Teljes név: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="teljes_név" name="teljes_név[name]"
                                        required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="cégnév" class="text-black">Cégnév (opcionális) </label>
                                    <input type="text" class="form-control" id="cégnév" name="cégnév">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="adószám" class="text-black">Adószám (opcionális)</label>
                                    <input type="text" class="form-control" id="adószám" name="adószám">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="irányítószám" class="text-black">Irányítószám <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required="" id="irányítószám"
                                        name="irányítószám[zip]" placeholder="Irányítószám">
                                </div>
                                <div class="col-md-6">
                                    <label for="város" class="text-black">Város <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required="" id="város"
                                        name="város[city]" placeholder="Város">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="utca" class="text-black">Utca <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required="" id="utca"
                                        name="utca[street]" placeholder="Utca">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="házszám" class="text-black">Házszám, emelet, ajtó </label>
                                <input type="text" class="form-control" required="" id="házszám"
                                    name="házszám[number]" placeholder="Házszám, emelet , ajtó (opcionális)">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email" class="text-black">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text" required="" class="form-control" id="email"
                                        name="email[email]">
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <div class="col-md-12">
                                    <label for="telefonszám" class="text-black">Telefon <span
                                            class="text-danger">*</span></label>
                                    <input type="text" required="" class="form-control" id="telefonszám"
                                        name="telefonszám[phone]" placeholder="telefonszám">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="megjegyzés" class="text-black">Megjegyzés</label>
                                <textarea name="megjegyzés" id="megjegyzés" cols="30" rows="5" class="form-control"
                                    placeholder="Ide írd a megjegyzést..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black font-heading-serif">Fizetési mód</h2>
                                <div class="p-3 px-5 border mb-3">

                                    <div class="border my-1 p-3 rounded">
                                        <h3 class="h6 mb-0"><a class="d-block collapsed" data-toggle="collapse"
                                                href="#collapsebank" role="button" aria-expanded="false"
                                                aria-controls="collapsebank">Utánvétes fizetés | 1500 forint</a></h3>
                                        <div class="collapse" id="collapsebank" style="">
                                            <div class="py-2 pl-0">
                                                <p class="mb-0" id="para1">A futárszolgálat díja 1500 forintba
                                                    kerül. Az áru átvételekor kérjük lehetőség szerint a pontos összeget
                                                    szíveskedjék a futárnak fizetni! Bankkártyával való fizetés lehetséges.
                                                    Az áru megrendelésétől számított 3 napon belül szállítunk.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black font-heading-serif">A rendelése</h2>
                                <div class="p-3 px-5 border mb-3">
                                    <table class="table site-block-order-table mb-5">
                                        <thead>
                                            <tr>
                                                <th>Termék</th>
                                                <th>Ára</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $sor)
                                                <tr>
                                                    <td>{{ $sor['name'] }}<strong
                                                            class="mx-2">x</strong>{{ $sor['quantity'] }}</td>
                                                    <td>{{ $sor['price'] }} Ft</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Nettó</strong></td>
                                                <td class="text-black">{{ $netto }} Ft</td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Bruttó</strong></td>
                                                <td class="text-black"><strong>{{ $brutto }} Ft</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Szállítási díj</strong>
                                                </td>
                                                <td class="text-black">1500 Ft</td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Rendelés összesen</strong>
                                                </td>
                                                <td class="text-black font-weight-bold"><strong>{{ $allp }}
                                                        Ft</strong></td>
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
                </div>
            </form>
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
