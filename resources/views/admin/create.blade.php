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
                                <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Új termék felvétele</h6>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="input-group input-group-static mb-4">
                                    <label>Termék neve</label>
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
                                        <button type="button" class="btn btn-info btn-lg w-100" data-bs-toggle="modal"
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
                                        <button type="button" class="btn btn-info btn-lg w-100" data-bs-toggle="modal"
                                            data-bs-target="#addbrand">
                                            Márka felvétele
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Ára</label>
                                            <input type="text" name="price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Akciós ára</label>
                                            <input type="text" name="actionprice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Barcode</label>
                                            <input type="text" name="barcode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Darabszám</label>
                                            <input type="number" name="quantity" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Űrtartalom</label>
                                            <input type="text" name="liter" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Alkoholfok</label>
                                            <input type="text" name="alcohol" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Egyéb jellemző pl.(évjárat, szín)</label>
                                            <input type="text" name="other" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Áfa</label>
                                            <input type="text" name="vat" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <label class="custom-control-label" for="customCheck1">Elérhető:</label>
                                            <input class="form-check-info" name="active" type="checkbox"
                                                id="fcustomCheck1" checked="">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlTextarea1" class="ms-0">Leírás</label>
                                    <textarea name="description" id="editor"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Termék képe</label>
                                            <input type="file" name="file" id="chooseFile" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-info btn-lg w-100"
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
                            <button type="submit" class="btn bg-gradient-info">Mentés</button>
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
                                <label class="form-label">Kategória neve</label>
                                <input class="form-control" list="addcategoryselect1" id="subcategory"
                                    name="subcategory" oninput='addcategoryselect1()'>
                                <datalist id="addcategoryselect1">
                                    @foreach ($category as $i)
                                        <option value="{{ $i->subcategory }}">
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">Származási ország</label>
                                <input class="form-control" list="addcategoryselect2" id="subcategory1"
                                    name="subcategory1" oninput='addcategoryselect2()'>
                                <datalist id="addcategoryselect2">
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">Ízesítés</label>
                                <input class="form-control" list="addcategoryselect3" id="subcategory2"
                                    name="subcategory2" oninput='addcategoryselect3()'>
                                <datalist id="addcategoryselect3">
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">Formátum</label>
                                <input class="form-control" list="addcategoryselect4" id="subcategory3"
                                    name="subcategory3" oninput='addcategoryselect4()'>
                                <datalist id="addcategoryselect4">
                                </datalist>
                            </div>
                            <div class="input-group input-group-static mb-4">
                                <label class="form-label">Egyéb</label>
                                <input class="form-control" list="addcategoryselect5" id="subcategory4"
                                    name="subcategory4">
                                <datalist id="addcategoryselect5">
                                </datalist>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                data-bs-dismiss="modal">Bezárás</button>
                            <button type="submit" class="btn bg-gradient-info">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="{{ asset('trumbowyg/trumbowyg.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/base64/trumbowyg.base64.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/emoji/trumbowyg.emoji.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/fontfamily/trumbowyg.fontfamily.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/fontsize/trumbowyg.fontsize.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/giphy/trumbowyg.giphy.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/history/trumbowyg.history.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/indent/trumbowyg.indent.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/lineheight/trumbowyg.lineheight.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/noembed/trumbowyg.noembed.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js') }}"></script>
    <script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/0.35/dist/jquery-resizable.min.js"></script>
    <script src="{{ asset('trumbowyg/plugins/resizimg/trumbowyg.resizimg.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/table/trumbowyg.table.min.js') }}"></script>
    <script src="{{ asset('trumbowyg/plugins/pasteembed/trumbowyg.pasteembed.min.js') }}"></script>


    <script>
        $('#editor')
            .trumbowyg({
                btnsDef: {
                    image: {
                        dropdown: ['base64'],
                        ico: 'insertImage'
                    }
                },
                btns: [
                    ['historyUndo', 'historyRedo'],
                    ['indent', 'outdent'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['foreColor', 'backColor'],
                    ['link'],
                    ['lineheight'],
                    ['fontsize'],
                    ['emoji'],
                    ['fontfamily'],
                    ['image'], // Our fresh created dropdown
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen'],
                    ['table'],
                    ['tableCellBackgroundColor', 'tableBorderColor']

                ],
                plugins: {
                    giphy: {
                        apiKey: 'xxxxxxxxxxxx'
                    }
                }
            });
            </script>
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
        <div class="col-lg-3 col-sm-6 col-12">
            <button class="btn bg-gradient-success w-100 mb-0 toast-btn" type="button" data-target="successToast">Success</button>
          </div>
        </div>
    </main>
@endsection
