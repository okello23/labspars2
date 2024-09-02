<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>

    <!-- Theme Style CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" /> --}}


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Africa-PGI NIMS') }}</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" />

    {{-- <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" /> --}}
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Include Select2 library and CSS -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/common.css') }}" />

    <!-- flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- iziToast CSS -->
    <link href="{{ asset('assets/plugins/izitoast/css/iziToast.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Push CSS -->
    <style>
        .scrollabe-content {
            height: 350px;
            margin: 5px auto;
        }

        .scrollable {
            overflow-y: auto;
            max-height: 340px;
        }
           ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
            box-shadow: inset 0 0 5px grey; 
            border-radius: 10px;
            }
            
            /* Handle */
            ::-webkit-scrollbar-thumb {
            background: #9F2242; 
            border-radius: 13px;
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
            background: #c5113e; 
            }
        .view-wrapper {
            width: 70%;
            height: auto;
            margin: 10px auto;
            border: 1px solid #cbcbcb;
            background: white;
        }

        @media print {
            .view-wrapper {
                width: 100%;
                height: auto;
                margin: 2px auto;
                margin-top: -12px;
                border: 0px;
                background: white;
            }
        }

        .report {
            position: relative;
            background-color: #fff;
            min-height: 680px;
            padding: 15px;
        }

        .report main .notices {
            padding-left: 6px;
            border-left: 6px solid #8d310a;
            background: #e7f2ff;
            padding: 10px;
        }
    </style>
    @stack('css')

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />

    <style>
        .view-wrapper {
            width: 70%;
            height: auto;
            margin: 10px auto;
            border: 1px solid #cbcbcb;
            background: white;
        }

        @media print {
            .view-wrapper {
                width: 100%;
                height: auto;
                margin: 2px auto;
                margin-top: -12px;
                border: 0px;
                background: white;
            }
        }
    </style>
    @livewireStyles
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <livewire:layouts.partials.assets-navigation-component />
        <!--end sidebar wrapper -->

        <!--start header -->
        <livewire:layouts.partials.header-component />
        <!--end header -->

        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                {{ $slot }}
            </div>
            <!--End Row-->
            <livewire:layouts.partials.footer-component />
        </div>

        <!--end wrapper-->

        <!--start switcher-->

        <!--end switcher-->
        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!--plugins-->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/plugins/jquery-knob/excanvas.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script> --}}

        <script src="{{ asset('assets/plugins/izitoast/js/iziToast.min.js') }}"></script>           
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/js/sort.js') }}"></script>

        <script src="{{ asset('assets/js/logistics.js') }} "></script>
        {{-- <script>
        $(function() {
            $(".knob").knob();
        });
        </script> --}}

        {{-- <script src="{{ asset('assets/js/index.js') }}"></script> --}}
        <!--app JS-->
        <script src="{{ asset('assets/js/app.js') }}"></script>
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

        @stack('scripts')


</body>

</html>
