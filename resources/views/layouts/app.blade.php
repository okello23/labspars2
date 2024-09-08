<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lab Spars') }}|@yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description"
        content="CPHL Lab Spars">
    <meta name="UNHLS" content="Developed for CPHL">

    <link rel="icon" href="{{ asset('/images/user.jpg') }}" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/izitoast/css/iziToast.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/mooli.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/multi-wizard-step.css') }}">
    @stack('css')
    @livewireStyles
</head>
<body>

    <div id="body" class="theme-green">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div  class="mt-3"><img src="{{ asset('images/loader') }}" width="80" height="100" alt="">
                </div>
                <p>Please wait...</p>
            </div>
        </div>

        <!-- Theme Setting -->
        <div class="themesetting">
            <a href="javascript:void(0);" class="theme_btn"><i class="fa fa-gear fa-spin"></i></a>
            <ul class="list-group">
                <li class="list-group-item">
                    <ul class="choose-skin list-unstyled mb-0">
                        <li data-theme="green" class="active">
                            <div class="green"></div>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                        </li>
                        <li data-theme="blush">
                            <div class="blush"></div>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                        </li>
                        <li data-theme="timber">
                            <div class="timber"></div>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                        </li>
                        <li data-theme="amethyst">
                            <div class="amethyst"></div>
                        </li>
                    </ul>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <span>Light Sidebar</span>
                    <label class="switch sidebar_light">
                        <input type="checkbox" checked="">
                        <span class="slider round"></span>
                    </label>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <span>Gradient</span>
                    <label class="switch gradient_mode">
                        <input type="checkbox" checked="">
                        <span class="slider round"></span>
                    </label>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <span>Dark Mode</span>
                    <label class="switch dark_mode">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </li>
                <li class="list-group-item d-flex align-items-center justify-content-between">
                    <span>RTL version</span>
                    <label class="switch rtl_mode">
                        <input type="checkbox">
                        <span class="slider round"></span>
                    </label>
                </li>
            </ul>
        </div>

        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>

        <div id="wrapper">

            <!-- Page top navbar -->

            <livewire:layouts.partials.header-component />
            <!-- Main left sidebar menu -->
            <livewire:layouts.partials.sidebar-navigation-component />
            <!-- Right bar chat  -->

            <!-- Main body part  -->
            <div id="main-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>

    <!-- Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/izitoast/js/iziToast.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script> -->
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <!-- Vedor js file and create bundle with grunt  -->


    <!-- Project core js file minify with grunt -->
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

    @livewireScripts
    <script>
        window.addEventListener('alert', event => {

            if (event.detail.type == 'success') {
                iziToast.success({
                    title: 'Success!',
                    message: `${event.detail.message}`,
                    timeout: 5000,
                    position: 'topRight'
                });
            }

            if (event.detail.type == 'Error') {
                iziToast.error({
                    title: 'Error!',
                    message: `${event.detail.message}`,
                    timeout: 5000,
                    position: 'topRight'
                });
            }

            if (event.detail.type == 'warning') {
                iziToast.warning({
                    title: 'Warning!',
                    message: `${event.detail.message}`,
                    timeout: 5000,
                    position: 'topRight'
                });
            }
        });

        window.addEventListener('switch-theme', event => {
            $("html").attr("class", `${event.detail.theme}`)
        });

        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.message,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });

        window.addEventListener('swal:confirm', event => {
            swal({
                    title: event.detail.message,
                    text: event.detail.text,
                    icon: event.detail.type,
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('remove');
                    } else {
                        window.livewire.emit('cancel');
                    }
                });
        });
    </script>
  <script>
    $(document).ready(function() {
        // Get the current URL
        var currentUrl = window.location.href;

        // Add 'active' class to the parent and dropdown links with matching href
        $('nav.sidebar-nav ul li a.has-arrow').each(function() {
            if (currentUrl.includes($(this).attr('href'))) {
                $(this).addClass('active');
                $(this).parent().find('ul').addClass('in');
            }
        });

        // Check if the child link is active and add 'active' class to its parent and dropdown links
        $('nav.sidebar-nav ul li ul li a').each(function() {
            if (currentUrl.includes($(this).attr('href'))) {
                $(this).addClass('active');
                $(this).closest('ul').addClass('in');
                $(this).closest('ul').parent().find('a.has-arrow').addClass('active');
            }
        });
    });
</script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    @stack('scripts')
</body>

</html>
