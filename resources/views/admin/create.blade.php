@extends('admin.layout')
@section('admincontent')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <form action="{{ route('productsave') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Új termék felvétele</h6>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="input-group input-group-static mb-4">
                                    <label class="form-label">Termék neve</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="exampleFormControlSelect1" class="ms-0">Fő kategoria</label>
                                            <select class="form-control" name="categoryselect1" id="categoryselect1">
                                                <option value="">Válassz</option>
                                                @foreach ($category as $i)
                                                    <option value="{{ $i->subcategory }}">{{ $i->subcategory }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4" id="catselect1">
                                            <label for="exampleFormControlSelect1" class="ms-0">Származási ország</label>
                                            <select class="form-control" name="categoryselect2" id="categoryselect2">
                                                <option value="">Válassz</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4" id="catselect2">
                                            <label for="exampleFormControlSelect1" class="ms-0">Ízesítés</label>
                                            <select class="form-control" name="categoryselect3" id="categoryselect3">
                                                <option value="">Válassz</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4" id="catselect3">
                                            <label for="exampleFormControlSelect1" class="ms-0">Formátum</label>
                                            <select class="form-control" name="categoryselect4" id="categoryselect4">
                                                <option value="">Válassz</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4" id="catselect4">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alkategória 4</label>
                                            <select class="form-control" name="categoryselect5" id="categoryselect5">
                                                <option value="">Válassz</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                            data-bs-target="#addcategory">
                                            Kategória felvétele
                                        </button>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="exampleFormControlSelect1" class="ms-0">Márka</label>
                                            <select class="form-control" name="brandselect" id="brandselect">
                                                <option value="">Válassz</option>
                                                @foreach ($brand as $i)
                                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                            data-bs-target="#addbrand">
                                            Márka felvétele
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Ára</label>
                                            <input type="text" name="price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Akciós ára</label>
                                            <input type="text" name="actionprice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Barcode</label>
                                            <input type="text" name="barcode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Darabszám</label>
                                            <input type="number" name="quantity" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Űrtartalom</label>
                                            <input type="text" name="liter" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Egyéb jellemző pl.(évjárat, szín)</label>
                                            <input type="text" name="other" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label class="form-label">Áfa</label>
                                            <input type="text" name="vat" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <label class="custom-control-label" for="customCheck1">Elérhető:</label>
                                            <input class="form-check-input" name="active" type="checkbox"
                                                id="fcustomCheck1" checked="">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlTextarea1" class="ms-0">Leírás</label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Termék képe</label>
                                            <input type="file" name="file" id="chooseFile" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-lg w-100"
                                            data-bs-toggle="modal">
                                            Termék felvétele
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <div class="modal fade" id="addbrand" tabindex="-1" role="dialog" aria-labelledby="addbrandLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('brandsave') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-normal" id="addbrandLabel">Új
                                kategória</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">Márka neve</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label>Márka képe</label>
                                <input type="file" name="file" id="chooseFile" class="form-control">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">Bezárás</button>
                            <button type="submit" class="btn bg-gradient-primary">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="addcategoryLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('categorysave') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-normal" id="addcategoryLabel">Új
                                kategória</h5>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">kategória neve</label>
                                <input class="form-control" list="addcategoryselect1" id="subcategory"
                                    name="subcategory" oninput='addcategoryselect1()'>
                                <datalist id="addcategoryselect1">
                                    @foreach ($category as $i)
                                        <option value="{{ $i->subcategory }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">alkategória neve</label>
                                <input class="form-control" list="addcategoryselect2" id="subcategory1"
                                    name="subcategory1" oninput='addcategoryselect2()'>
                                <datalist id="addcategoryselect2">
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">alkategória neve</label>
                                <input class="form-control" list="addcategoryselect3" id="subcategory2"
                                    name="subcategory2" oninput='addcategoryselect3()'>
                                <datalist id="addcategoryselect3">
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">alkategória neve</label>
                                <input class="form-control" list="addcategoryselect4" id="subcategory3"
                                    name="subcategory3" oninput='addcategoryselect4()'>
                                <datalist id="addcategoryselect4">
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">alkategória neve</label>
                                <input class="form-control" list="addcategoryselect5" id="subcategory4"
                                    name="subcategory4">
                                <datalist id="addcategoryselect5">
                                </datalist>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">Bezárás</button>
                            <button type="submit" class="btn bg-gradient-primary">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function addcategoryselect1() {
                if ($('#subcategory').val() != "") {
                    var select1 = $('#subcategory').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('addcategory1') }}",
                        type: "POST",
                        data: {
                            select1: select1,
                            _token: _token
                        },
                        success: function(result) {
                            $('#addcategoryselect2').html(result);
                        }
                    })
                }
            }

            function addcategoryselect2() {
                if ($('#subcategory1').val() != "") {
                    var select1 = $('#subcategory').val();
                    var select2 = $('#subcategory1').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('addcategory2') }}",
                        type: "POST",
                        data: {
                            select1: select1,
                            select2: select2,
                            _token: _token
                        },
                        success: function(result) {
                            $('#addcategoryselect3').html(result);
                        }
                    })
                }
            }

            function addcategoryselect3() {
                if ($('#subcategory2').val() != "") {
                    var select1 = $('#subcategory').val();
                    var select2 = $('#subcategory1').val();
                    var select3 = $('#subcategory2').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('addcategory3') }}",
                        type: "POST",
                        data: {
                            select1: select1,
                            select2: select2,
                            select3: select3,
                            _token: _token
                        },
                        success: function(result) {
                            $('#addcategoryselect4').html(result);
                        }
                    })
                }
            }

            function addcategoryselect4() {
                if ($('#subcategory3').val() != "") {
                    var select1 = $('#subcategory').val();
                    var select2 = $('#subcategory1').val();
                    var select3 = $('#subcategory2').val();
                    var select4 = $('#subcategory3').val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('addcategory4') }}",
                        type: "POST",
                        data: {
                            select1: select1,
                            select2: select2,
                            select3: select3,
                            select4: select4,
                            _token: _token
                        },
                        success: function(result) {
                            $('#addcategoryselect5').html(result);
                        }
                    })
                }
            }
            $(document).ready(function(e) {
                $("#categoryselect1").change(function() {
                    if ($('#categoryselect1').val() != "") {
                        var select1 = $('#categoryselect1').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{ route('category1') }}",
                            type: "POST",
                            data: {
                                select1: select1,
                                _token: _token
                            },
                            success: function(result) {
                                $('#categoryselect2').html(result);
                            }
                        })
                    }
                });
                $("#categoryselect2").change(function() {
                    if ($('#categoryselect2').val() != "") {
                        var select1 = $('#categoryselect1').val();
                        var select2 = $('#categoryselect2').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{ route('category2') }}",
                            type: "POST",
                            data: {
                                select1: select1,
                                select2: select2,
                                _token: _token
                            },
                            success: function(result) {
                                $('#categoryselect3').html(result);
                            }
                        })
                    }
                });
                $("#categoryselect3").change(function() {
                    if ($('#categoryselect3').val() != "") {
                        var select1 = $('#categoryselect1').val();
                        var select2 = $('#categoryselect2').val();
                        var select3 = $('#categoryselect3').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{ route('category3') }}",
                            type: "POST",
                            data: {
                                select1: select1,
                                select2: select2,
                                select3: select3,
                                _token: _token
                            },
                            success: function(result) {
                                $('#categoryselect4').html(result);
                            }
                        })
                    }
                });
                $("#categoryselect4").change(function() {
                    if ($('#categoryselect4').val() != "") {
                        var select1 = $('#categoryselect1').val();
                        var select2 = $('#categoryselect2').val();
                        var select3 = $('#categoryselect3').val();
                        var select4 = $('#categoryselect4').val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{ route('category4') }}",
                            type: "POST",
                            data: {
                                select1: select1,
                                select2: select2,
                                select3: select3,
                                select4: select4,
                                _token: _token
                            },
                            success: function(result) {
                                $('#categoryselect5').html(result);
                            }
                        })
                    }
                });
            });
        </script>
        <button class="btn bg-gradient-success w-100 mb-0 toast-btn" type="button"
        data-target="successToast">Success</button>
        <div class="position-fixed bottom-1 end-1 z-index-2">
            <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast"
              aria-atomic="true">
              <div class="toast-header border-0">
                <i class="material-icons text-success me-2">
                  check
                </i>
                <span class="me-auto font-weight-bold">Material Dashboard </span>
                <small class="text-body">11 mins ago</small>
                <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
              </div>
              <hr class="horizontal dark m-0">
              <div class="toast-body">
                Hello, world! This is a notification message.
              </div>
            </div>
    </div>
        @if ($message = Session::get('success'))
        <div class="position-fixed bottom-1 end-1 z-index-2">
            <div class="toast fade hide p-2 bg-white" role="alert" aria-live="assertive" id="successToast"
              aria-atomic="true">
              <div class="toast-header border-0">
                <i class="material-icons text-success me-2">
                  check
                </i>
                        <span class="me-auto font-weight-bold">{{$message}} </span>
                        <i class="fas fa-times text-md ms-3 cursor-pointer" data-bs-dismiss="toast"
                            aria-label="Close"></i>
                    </div>
                    <hr class="horizontal dark m-0">
                </div>
            </div>
        @endif
        <footer class="footer py-4  ">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted"
                                    target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted"
                                    target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted"
                                    target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                                    target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        </div>
    </main>
@endsection
