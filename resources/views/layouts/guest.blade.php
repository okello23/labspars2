<!doctype html>
<html lang="en">

<head>
    <title>Lab Spars | @yield('title')</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="The Lab SPARS electronic tool digitizes data entry from health facility visits, replicating the paper assessment tool with an intuitive, user-friendly design. Version 2 adds advanced validation, customizable reports, a refined interface and faster processing enhancing data quality, reporting, and user experience.">
<meta name="CPHL-Uganda" content="Developed with support from CPHL-Uganda">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/animate-css/vivify.min.css') }}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/mooli.min.css') }}">

</head>

<body>

<div id="body" class="theme-green">
    <div class="auth-main">
        <div class="auth_div vivify fadeIn">
            <div class="auth_brand">
            </div>
            <!-- <figcaption><b style="font-family:Cursive; font-size:35px; text-align: justify;">Genomic LIMS</b><figcaption> -->
            @yield('content')
        </div>
        <!-- <div class="animate_lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div> -->
    </div>
</div>

<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

<!-- Vedor js file and create bundle with grunt  -->
</body>
</html>
