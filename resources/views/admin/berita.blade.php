@section('Dashboard','superadmin')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Sidebar -->
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
                        <img src="{{ asset('foto/' . Auth::user()->admin) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
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
                            <a href="{{url('dashboard/admin')}}" class="nav-link ">
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
                            <a href="{{route('data_santri')}}" class="nav-link active">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Data
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/gallery.html" class="nav-link">
                                <i class="nav-icon fa fa-envelope"></i>
                                <p>
                                    Ajuan Keterlambatan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link">
                                <i class="nav-icon fas fa fa-sign-out"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <nav class="navbar navbar-light bg-light">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success col-md-2 mb-2">Cetak Excel</button>
                            <button type="button" class="btn btn-warning col-md-2 mb-2">Cetak Pdf</button>
                            <div class="col-md-5 mb-10">
                                <form class="row g-3">
                                    <div class="col-auto">
                                        <input class="form-control" type="text" placeholder="Search" aria-label="default input example">
                                    </div>
                                    <button class="btn btn-primary" type="submit">
                                        Cari
                                    </button>
                                </form>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="card-title">
                                        <b>BERITA</b>
                                    </h2>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Gambar</th>
                                                    <th>Judul</th>
                                                    <th>isi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($beritas as $item )
                                                <tr>
                                                    <td>{{++$i}}</td>
                                                    <td>
                                                        @if ($item->gambar)
                                                        <img class="mb-3" src="{{url('gambar/'.$item->gambar)}}" style="width: 50px;">
                                                        @endif
                                                    </td>
                                                    <td>{{$item->judul}}</td>
                                                    <td>{{$item->isi}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.row -->
                </div>
                </nav>
            </section>
        </div>
        <!-- /.sidebar -->
        <!-- /.card -->
    </div>
    <!-- Tautan navigasi paginasi -->
    {{ $beritas->links() }}
</body>
<!-- Content Wrapper. Contains page content -->
@include('dadmin.style')
@include('dadmin.script')