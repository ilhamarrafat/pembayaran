@section('Dashboard','superadmin')
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
        <!-- /.sidebar-menu -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <nav class="navbar navbar-light bg-light">
                        <div class="col-md-12">


                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h4>
                                        <b>
                                            DATA SANTRI
                                        </b>
                                    </h4>
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
                                    <div class="mb-1">
                                        <a class="btn btn-success" href="{{Route('export_data_santri')}}">Cetak Excel</a>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Foto</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Alamat</th>
                                                    <th>Tempat Lhr</th>
                                                    <th>Tgl Lahir</th>
                                                    <th>Tahun Masuk</th>
                                                    <th>Tahun Keluar</th>
                                                    <th>Kelas</th>
                                                    <th>Tingkat</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($santri as $item)
                                                <tr>
                                                    <td>{{ ++$i }}</td>
                                                    <td>
                                                        @if ($item->foto)
                                                        <img class="mb-1" src="{{url('storage/' . $item->foto)}}" style="width: 50px;">
                                                        @endif
                                                    </td>
                                                    <td>{{$item->nama}}</td>
                                                    <td>{{$item->Jenis_kelamin}}</td>
                                                    <td>{{$item->alamat}}</td>
                                                    <td>{{$item->Tmp_lhr}}</td>
                                                    <td>{{$item->Tgl_lhr}}</td>
                                                    <td>{{$item->Thn_masuk}}</td>
                                                    <td>{{$item->Thn_keluar}}</td>
                                                    <td>{{$item->kelas->kelas}}</td>
                                                    <td>{{$item->tingkat->tingkat}}</td>
                                                    <td>
                                                        <a href="{{ route('export.pdf', $item->Id_santri) }}">
                                                            <button class="icon-button-1">
                                                                <i class="fa fa-print mb-1" style="font-size:20px;"></i>
                                                            </button>
                                                        </a>
                                                    </td>
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
    </div>
    <!-- Tautan navigasi paginasi -->
    {{ $santri->links() }}
</body>
<!-- <div class="content-wrapper"> -->

<!-- </div> -->
<!-- <footer class="main-footer">
    <div class="container copyright text-center mb-2">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Admin</strong> <span>All Rights Reserved</span></p>
    <div class="credits">
    Designed by <a>Admin</a>
    </div>
    </div>
  </footer> -->
@include('dadmin.style')
@include('dadmin.script')