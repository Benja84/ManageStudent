<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>SGS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    @yield('aditionnal_css')
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <b class="logo-icon ps-2">
                            <img src="{{asset('assets/images/logo-icon.png')}}" alt="homepage" class="light-logo"/>
                        </b>
                        <span class="logo-text">
                            {{-- <img src="{{asset('assets/images/logo-text.png')}}" alt="homepage" class="light-logo" /> --}}
                            <label class="light-logo mt-2" >{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                        </span>
                    </a>
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="ti-menu ti-close"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                    </ul>

                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{asset('assets/images/users/1.jpg')}}" alt="user" class="rounded-circle" width="31">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                                {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="ti-user me-1 ms-1"></i>My Profile
                                </a> --}}
                                <a class="dropdown-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"><i class="fa fa-power-off me-1 ms-1"></i> Logout</button>
                                    </form>
                                </a>
                                <div class="dropdown-divider"></div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        {{-- Menu gauche --}}
        @include('layouts.sidebar')

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">{{ $title }}</h4>
                        <div class="ms-auto text-end">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ $page }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                {{-- @if ($errors->any())
                    <div class="alert alert-danger col-md-12" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif --}}
                @yield('content')
            </div>

            <footer class="footer text-center">

                Gestion scolaire , <i class="mdi mdi-copyright" aria-hidden="true"></i> {{date('Y')}}.
            </footer>
        </div>
    </div>
    @if(auth()->check())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Empêche le retour à la page de login
            if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
                window.location.reload();
            }
        });
    </script>
    @endif
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.ui.touch-punch-improved.js') }}"></script>

    <script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!-- this page js -->

    <script>
        if (window.performance) {
          if (performance.navigation.type === 2) {
            // Type 2 = navigateur back/forward
            location.href = "{{ route('login') }}";
          }
        }
      </script>




    {{-- <script src="{{ asset('dist/js/pages/mask/mask.init.js')}}"></script> --}}
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/libs/toastr/build/toastr.min.js')}}"></script>
    <script src="{{ asset('assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();


        function calculerAge(date){
            const dNaiss = new Date(date);
            if (isNaN(dNaiss)) return null;

            const today = new Date();
            let age = today.getFullYear() - dNaiss.getFullYear();
            const m = today.getMonth() - dNaiss.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dNaiss.getDate())) {
                age--;
            }
            return age;
        }
    </script>
    @yield('scripts')
</body>

</html>
