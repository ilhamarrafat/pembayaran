@include('superadmin.sidebar')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary">
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('template/assets/img/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Dashboard</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url('profile/' . Auth::user()->admin->foto) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
                    </div>
                    <div class="info">
                        <a>Hello, <strong>{{ Auth::user()->name }}</strong></a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('dashboard/superadmin') }}" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pembayaran.index') }}" class="nav-link">
                                <i class='nav-icon fas fa-wallet'></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('berita') }}" class="nav-link">
                                <i class="nav-icon fa fa-newspaper-o"></i>
                                <p>Berita</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link">
                                <i class="nav-icon far fa-address-card"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data') }}" class="nav-link">
                                <i class="nav-icon fas fa-database"></i>
                                <p>Data</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link" onclick="confirmLogout(event);">
                                <i class="nav-icon fa fa-sign-out"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="info-box bg-warning">
                                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Santri</span>
                                    <span class="info-box-number">{{ count($santri) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pemasukan Bulan Ini</span>
                                    <span class="info-box-number">Rp{{ number_format($pemasukanBulanIni, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Saldo</span>
                                    <span class="info-box-number">Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="info-box bg-danger">
                                <span class="info-box-icon"><i class="fa fa-area-chart"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Tagihan</span>
                                    <span class="info-box-number">Rp{{ number_format($totalTagihanBelumDibayar, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center">
            <div>
                <p>&copy; 2024 <strong>MAWAR</strong> All Rights Reserved. Designed by <a href="#">Admin</a></p>
            </div>
        </footer>
    </div>

    @include('dadmin.script')
</body>

<script>
    function confirmLogout(event) {
        event.preventDefault();
        if (confirm('Apakah Anda yakin ingin keluar?')) {
            window.location.href = "{{ route('logout') }}";
        }
    }
</script>