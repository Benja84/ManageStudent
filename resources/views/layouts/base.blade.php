<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>Student management</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
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
                    <a class="navbar-brand" href="index.html">
                        <b class="logo-icon ps-2">
                            <img src="../../assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <span class="logo-text">
                            <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" />
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
                                <img src="../../assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="ti-user me-1 ms-1"></i>My Profile
                                </a>
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
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item"> 
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Tableaux de bord</span>
                            </a>
                        </li>
                        <li class="sidebar-item"> 
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-account-multiple"></i>
                                <span class="hide-menu">Membres du personnel </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('members.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> Créer  </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('members.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-receipt"></i>
                                        <span class="hide-menu"> Liste du personnel </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> 
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-school"></i>
                                <span class="hide-menu">Etudiants </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('students.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> Créer  </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="form-wizard.html" class="sidebar-link">
                                        <i class="mdi mdi-receipt"></i>
                                        <span class="hide-menu"> Liste des étudiants </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> 
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-clipboard-account"></i>
                                <span class="hide-menu">Proffesseurs </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('students.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> Créer  </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="form-wizard.html" class="sidebar-link">
                                        <i class="mdi mdi-receipt"></i>
                                        <span class="hide-menu"> Liste des étudiants </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> 
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-calendar"></i>
                                <span class="hide-menu">Cours </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('courses.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> Créer  </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('courses.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-receipt"></i>
                                        <span class="hide-menu"> Liste des cours </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> 
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-book"></i>
                                <span class="hide-menu">Matières </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('subjects.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> Créer  </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('subjects.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-receipt"></i>
                                        <span class="hide-menu"> Liste des matières </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> 
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                                <i class="fas fa-building"></i>
                                <span class="hide-menu">Salle </span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('rooms.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-note-outline"></i>
                                        <span class="hide-menu"> Créer  </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('rooms.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-receipt"></i>
                                        <span class="hide-menu"> Liste des matières </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
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
                @yield('content')
            </div>

            <footer class="footer text-center">
                All Rights Reserved by Matrix-admin. Designed and Developed by <a
                    href="https://www.wrappixel.com">WrapPixel</a>.
            </footer>
        </div>
    </div>
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
    
    @yield('scripts')
</body>

</html>