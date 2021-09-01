<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | @yield('pageTitle') </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/menu/menu-types/vertical-menu-modern.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-gradient.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
        <!-- END: Theme CSS-->


        @yield('pageCss')

        <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('formValidation/css/formValidation.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bcs-core.css') }}">
        <!-- END: Custom CSS-->


    </head>
    @if(request()->routeIs('pos.index'))
    <body class="horizontal-layout horizontal-menu 2-columns  " data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
    @else
    <body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    @endif

    <!-- BEGIN: Header-->
        @include('layouts.includes.navbar')
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    @if(!request()->routeIs('pos.index'))
        @include('layouts.includes.sidebar')
    @endif
    <!-- END: Main Menu-->
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        @yield('pageContent')
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light navbar-border navbar-shadow">
        <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2019 <a class="text-bold-800 grey darken-2" href="https://1.envato.market/modern_admin" target="_blank">PIXINVENT</a></span><span class="float-md-right d-none d-lg-block">Hand-crafted & Made with<i class="ft-heart pink"></i><span id="scroll-top"></span></span></p>
    </footer>
    <!-- END: Footer-->
    @include('layouts.includes.modals')
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <script src="{{ asset('formValidation/js/formValidation.js') }}"></script>
    <script src="{{ asset('formValidation/js/framework/bootstrap.min.js') }}"></script>
    <script src="{{ asset('formValidation/js/globalValidationCustom.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.resetBtn').on('click', function (e){
            e.preventDefault();
            $(this).parents('form').trigger('reset');
        })

        $("body").delegate(".pickadate", "focusin", function () {
            $(this).pickadate({
                format: 'mm/d/yyyy',
                formatSubmit: 'mm/dd/yyyy',
            });
        });
        $('body .select2').select2({
            dropdownAutoWidth: true,
            width: '100%'
        });
    </script>

    @yield('pageJs')
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bcs-core.js') }}"></script>
    </body>
    <!-- END: Body-->

</html>
