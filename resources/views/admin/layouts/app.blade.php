<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="BRo50BKcBSbFtNDV2aE5RHXS6DX69Y6ll9PEvImY">
    <title>RTYS İdarə paneli</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link id="gull-theme" rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/perfect-scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/pickadate/classic.date.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .main-content-wrap {
            background-image: url({{ asset('assets/images/bg-main.png') }});
            backdrop-filter: invert(20%);
        }
    </style>
    @yield('css')
</head>
<body class="text-left main-body">
<div class='loadscreen' id="preloader">
    <div class="loader spinner-bubble spinner-bubble-primary">
    </div>
</div>
<!-- ============ Compact Layout start ============= -->
<!-- ============Deafult  Large SIdebar Layout start ============= -->
<div class="app-admin-wrap layout-sidebar-large clearfix">
    @include('admin.layouts.partials.topbar')
    <!-- header top menu end -->


    <div class="side-content-wrap">
        @include('admin.layouts.partials.sidebar')
    </div>
    <!--=============== Left side End ================-->

    <!-- ============ Body content start ============= -->
    <div class="main-content-wrap sidenav-open d-flex flex-column">
        <div class="main-content">
            @yield('content')
        </div>

        <!-- Footer Start -->
        <div class="flex-grow-1"></div>
        @include('layouts.partials.footer')
        <!-- fotter end -->
    </div>
    <!-- ============ Body content End ============= -->
</div>
<!--=============== End app-admin-wrap ================-->

<!-- ============ Search UI Start ============= -->


<!-- ============ Search UI End ============= -->


<!-- ============ Large Sidebar Layout End ============= -->


<!-- ============ Customizer ============= -->

<!-- ============ End Customizer ============= -->
<script src="{{ asset('assets/js/common-bundle-script.js')}}"></script>
<script src="{{ asset('assets/js/vendor/echarts.min.js')}}"></script>
<script src="{{ asset('assets/js/es5/echart.options.min.js')}}"></script>
<script src="{{ asset('assets/js/es5/dashboard.v1.script.js')}}"></script>
<script src="{{ asset('assets/js/script.js')}}"></script>
<script src="{{ asset('assets/js/sidebar.large.script.js')}}"></script>
<script src="{{ asset('assets/js/customizer.script.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script src="{{ asset('assets/js/vendor/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/js/vendor/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/js/form.basic.script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
@yield('js')
</body>
</html>
