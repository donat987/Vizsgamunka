<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>
        Termék felvétele
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('css/material-dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('trumbowyg/ui/trumbowyg.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/plugins/giphy/ui/trumbowyg.giphy.min.css') }}">
    <link rel="stylesheet" href="{{ asset('trumbowyg/plugins/table/ui/trumbowyg.table.min.css') }}">

</head>

<body class="g-sidenav-show bg-gray-200">
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps bg-white"
        id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer opacity-5 position-absolute end-0 top-0 d-none d-xl-none text-dark"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="/admin">
                <img src="{{ asset('assets/images/logo.png')}}"
                    class="navbar-brand-img h-100" alt="main_logo">
            </a>
        </div>
        <hr class="horizontal light mt-0 mb-2">
        <div class="collapse navbar-collapse w-auto ps ps--active-x" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Főoldal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/kuponok' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/kuponok">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Kuponok</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/akcio' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/akcio">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Csoportos akció</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/csomagolas' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/csomagolas">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Csomagolni váró</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/feladas' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/feladas">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Feladásra váró</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/teljesitett' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/teljesitett">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Teljesítésre váró</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/teljesitve' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/teljesitve">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Teljesítve</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/ujtermek' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/ujtermek">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Új Termék felvétele</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/termekek' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/termekek">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Termékek megtekintése</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/hamarosanelfogy' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/hamarosanelfogy">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Hamarosan elfogy</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/velemenyek' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/velemenyek">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Vélemények</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/blog' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/blog">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Új hír felvétele</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/blogok' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/blogok">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Hírek megtekintése</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ Request::path() === 'admin/kommentek' ? 'nav-link active text-dark bg-gradient-info' : 'nav-link text-dark ' }}"
                        href="/admin/kommentek">
                        <div class="text-center me-2 d-flex align-items-center justify-content-center text-dark">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Kommentek</span>
                    </a>
                </li>

            </ul>
            <div class="ps__rail-x" style="width: 250px; left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 214px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ps ps--active-y">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 border-radius-xl shadow-none position-sticky blur shadow-blur mt-4 left-auto top-1 z-index-sticky"
            id="navbarBlur" data-scroll="true" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                    <ul class="navbar-nav  justify-content-end">

                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ url('/logout') }}" class="nav-link font-weight-bold px-0 text-body">
                                <i class="fa fa-user me-sm-1" aria-hidden="true"></i>
                                <span class="d-sm-inline d-none">Kijelentkezés</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link p-0 text-body" id="iconNavbarSidenav">
                              <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                              </div>
                            </a>
                          </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @yield('admincontent')

            <footer class="footer py-4  ">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-lg-between">
                        <div class="col-lg-6 mb-lg-0 mb-4">
                            <div class="copyright text-center text-sm text-muted text-lg-start">
                                ©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>2023,
                                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                                <a href="https://www.creative-tim.com" class="font-weight-bold"
                                    target="_blank">Creative Tim</a>
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
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 872px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 594px;"></div>
        </div>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('js/core/popper.min.js')}}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{ asset('js/plugins/chartjs.min.js')}}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async="" defer="" src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/material-dashboard.min.js')}}"></script>


</body>

</html>
