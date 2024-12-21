@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <aside class="main-sidebar sidebar-dark-primary mb-20 ">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{asset('template/assets/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Dashboard</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url('profile/' . Auth::user()->admin->foto) }}" class="img-circle elevation-2" alt="" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
                    </div>
                    <div class="info">
                        <a>Hello,
                            <a>{{Auth::user()->name}}</a>
                        </a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="{{url('dashboard/admin')}}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pembayaran_santri')}}" class="nav-link ">
                                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                                <p>
                                    Pembayaran
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('berita_show')}}" class="nav-link">
                                <i class="nav-icon fa fa-newspaper-o" style="font-size:20px"></i>
                                <p>
                                    Berita
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile_admin')}}" class="nav-link">
                                <i class="nav-icon far fa-address-card"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('data_santri')}}" class="nav-link ">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Data
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                                <i class="nav-icon fas fa-sign-out"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                        <script>
                            function confirmLogout() {
                                if (confirm('Apakah Anda yakin ingin keluar?')) {
                                    window.location.href = "{{ route('logout') }}";
                                }
                            }
                        </script>
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{asset('template/assets/img/logo.png')}}" alt="" height="60" width="60">
        </div>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                @yield('content')
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Santri</span>
                                    <span class="info-box-number">{{count($santri)}}</span>

                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pemasukan bulan ini</span>
                                    <span class="info-box-number">
                                        10
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-bar-chart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Saldo</span>
                                    <span class="info-box-number">760</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-area-chart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Pengeluaran</span>
                                    <span class="info-box-number">41,410</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="container copyright text-center mt-4">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">Admin</strong> <span>All Rights Reserved</span></p>
                <div class="credits">
                    Designed by <a>Admin</a>
                </div>
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('dadmin.script')
</body>
@include('dadmin.style')
@include('dadmin.script')
<script>
    window.onload = function() {
        var successMessage = "{{ session('success') }}";
        var errorMessage = "{{ session('error') }}";

        if (successMessage) {
            alert(successMessage);
        }

        if (errorMessage) {
            alert(errorMessage);
        }
    }
</script>