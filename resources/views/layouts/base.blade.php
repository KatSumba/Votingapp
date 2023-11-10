<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EVoting</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Include Toastr CSS and JavaScript -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Custom styles-->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
   <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- ChartJs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark  sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-check-to-slot"></i>
                </div>
                @if (auth()->check() && auth()->user()->role == 1)
                    <div class="sidebar-brand-text mx-3">EVoting Admin <sup></sup></div>
                @endif
                @if (auth()->check() && auth()->user()->role == 0)
                    <div class="sidebar-brand-text mx-3">EVoting Student <sup></sup></div>
                @endif
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="/home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            @if (auth()->check() && auth()->user()->role == 1)
                <!-- Heading -->
                <div class="sidebar-heading">
                    Manage Users
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link " href="/users/admin" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                        <span>Admin</span>
                    </a>
                    <a class="nav-link " href="/users/students" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i>    
                        <span>Students</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Manage Applications
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link " href="/applications" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-book" aria-hidden="true"></i>    
                        <span>Applications</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Manage Elections
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link " href="/positions" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i>    
                        <span>Positions</span>
                    </a>
                    <a class="nav-link " href="#" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-cog" aria-hidden="true"></i>    
                        <span>Configure Elections</span>
                    </a>
                    <a class="nav-link " href="/results" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-file" aria-hidden="true"></i>    
                        <span>Results</span>
                    </a>
                </li>
            @endif
            @if (auth()->check() && auth()->user()->role == 0)
                <!-- Heading -->
                <div class="sidebar-heading">
                    Manage Profile
                </div>

                <li class="nav-item">
                    <a class="nav-link " href="/profile" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i>    
                        <span>My Profile</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Election Brief
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link " href="/candidates" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-info" aria-hidden="true"></i>    
                        <span>Qualified Candidates</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Voting Portal
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link " href="/ballot" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-check-to-slot" aria-hidden="true"></i>    
                        <span>Ballot</span>
                    </a>
                    <a class="nav-link " href="/results" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-fw fa-file" aria-hidden="true"></i>    
                        <span>Results</span>
                    </a>
                </li>
            @endif
            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Interface
            </div> -->
            <!-- Nav Item - Pages Collapse Menu -->
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li> -->
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->FirstName }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/img/undraw_profile.svg')}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    
                                        {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')
                

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; EVoting 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <!-- <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script> --> 
    
    <!-- Datatables links-->
    <!-- Include DataTables CSS and JavaScript (or use CDN) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


    
    @yield('scripts')

    <script>
        @if (session('notification'))
        toastr.options = {
            "closeButton": true,
            "positionClass": "toast-top-right",
        };
        var notification = @json(session('notification'));

        // Show the notification using Toastr
        toastr[notification['alert-type']](notification['message']);
    @endif
        //Customized Notification Apearance
        $(document).ready(function() {
        // Initialize Toastr with custom options
        toastr.options = {
            closeButton: true,        // Show close button
            positionClass: 'toast-top-right', // Position of notifications
            timeOut: 5000,             // Duration in milliseconds (5 seconds)
            extendedTimeOut: 2000,     // Additional duration for when the user hovers over the notification
            showMethod: 'fadeIn',   // Show animation
            hideMethod: 'fadeOut',     // Hide animation
            newestOnTop: true          // Show newest notifications on top
        };
            
            
        });
    </script>
</body>

</html>