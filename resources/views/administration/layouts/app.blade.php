<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>Nice admin Template - The Ultimate Multipurpose admin template</title>
    <!-- Custom CSS -->
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    .preloader {
        position: fixed;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, #1e88e5 0%, #90caf9 100%);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .flight-loader {
        position: relative;
        width: 200px;
        height: 200px;
    }

    .plane {
        position: absolute;
        width: 100%;
        height: 100%;
        animation: fly 3s infinite ease-in-out;
    }

    .plane svg {
        width: 60px;
        height: 60px;
        fill: white;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .clouds {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .cloud {
        position: absolute;
        background: white;
        border-radius: 50px;
        animation: float 8s infinite linear;
        opacity: 0.8;
    }

    .cloud:nth-child(1) {
        width: 100px;
        height: 40px;
        top: 20%;
        left: -100px;
        animation-delay: 0s;
    }

    .cloud:nth-child(2) {
        width: 60px;
        height: 30px;
        top: 50%;
        left: -60px;
        animation-delay: 2s;
    }

    .loading-text {
        position: absolute;
        bottom: -40px;
        color: white;
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: uppercase;
        animation: pulse 1.5s infinite;
    }

    @keyframes fly {
        0%, 100% { transform: translate(0, 0) rotate(10deg); }
        50% { transform: translate(20px, -20px) rotate(-5deg); }
    }

    @keyframes float {
        from { transform: translateX(-100px); }
        to { transform: translateX(300px); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
@stack('styles')
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="flight-loader">
            <div class="plane">
                <svg viewBox="0 0 24 24">
                    <path d="M21,16V14L13,9V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V9L2,14V16L10,13.5V19L8,20.5V22L11.5,21L15,22V20.5L13,19V13.5L21,16Z"/>
                </svg>
            </div>
            <div class="clouds">
                <div class="cloud"></div>
                <div class="cloud"></div>
            </div>
            <div class="loading-text">Décollage...</div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('administration.includes.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('administration.includes.menu')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            @yield('fil_ariane')
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            @include('administration.includes.footer')
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <!--c3 charts -->
    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.js') }}"></script>
    <script src="{{asset('dist/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/libs/sweetalert2/sweet-alert.init.js')}}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/toastr/toastr-init.js') }}"></script>
    @if(Session::has('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ Session::get('success') }}", "Success!", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000,
                    extendedTimeOut: 2000,
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                });
            });
        </script>
    @endif
    @if(Session::has('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ Session::get('error') }}", "Error!", {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000,
                    extendedTimeOut: 2000,
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut"
                });
            });
        </script>
    @endif
    @stack('scripts')
</body>

</html>