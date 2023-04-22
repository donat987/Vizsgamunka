@extends('admin.layout')
@section('admincontent')
    <form action="{{ route('newssend') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="text-dark bg-gradient-info shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Hírlevél</h6>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="row">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlTextarea1" class="ms-0">Hírlevél</label>
                                <textarea id="editor" name="content"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-info btn-lg w-100" data-bs-toggle="modal">Küldés
                                </button>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>


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
                    ['tableCellBackgroundColor', 'tableBorderColor'],
                    ['giphy']

                ],
                plugins: {
                    giphy: {
                        apiKey: 'xxxxxxxxxxxx'
                    }
                }
            });
    </script>
@endsection
