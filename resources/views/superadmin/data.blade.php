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
            <img src="{{asset('template/assets/Admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
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
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('pembayaran')}}" class="nav-link">
                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                <p>
                  Pembayaran
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('berita')}}" class="nav-link">
                <i class="nav-icon fa fa-newspaper-o" style="font-size:20px"></i>
                <p>
                  Berita
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('profile')}}" class="nav-link">
                <i class="nav-icon far fa-address-card"></i>
                <p>
                  Profile
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('data')}}" class="nav-link active">
                <i class="nav-icon fas fa-database"></i>
                <p>
                  Data Santri
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
    <!-- /.sidebar-menu -->
    <div class="content-wrapper">

      <section class="content">
        <div class="container-fluid">
          <nav class="navbar navbar-light bg-light">
            <div class="col-md-12">
              <button type="button" class="btn btn-warning col-md-2 mb-2">Cetak Data</button>
              <button type="button" class="btn btn-success col-md-1 mb-2">Excel</button>
              <button type="button" class="btn btn-warning col-md-1 mb-2">pdf</button>

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

              <!-- Main row -->
              <!-- Left col -->
              <!-- /.card -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h3 class="card-title">Data Santri</h3>

                  <div class="card-tools">
                    <button>
                      <a class="btn btn-primary" href="{{ route('santri.create') }}">Tambah</a>
                    </button>
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
                        @foreach($santris as $item)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td>
                            @if ($item->foto)
                            <img class="mb-1" src="{{url('foto/'.$item->foto)}}" style="width: 50px;">
                            @endif
                          </td>
                          <td>{{$item->nama}}</td>
                          <td>{{$item->Jenis_kelamin}}</td>
                          <td>{{$item->alamat}}</td>
                          <td>{{$item->Tmp_lhr}}</td>
                          <td>{{$item->Tgl_lhr}}</td>
                          <td>{{$item->Thn_masuk}}</td>
                          <td>{{$item->Thn_keluar}}</td>
                          <td>{{$item->kelas}}</td>
                          <td>{{$item->tingkat}}</td>
                          <td>
                            <button class="icon-button-1">
                              <i class="fa fa-print mb-1" href="#" style="font-size:20px;"></i>
                            </button>
                            <form action="{{route('santri.edit', ['Id_santri' => $item])}}">
                              <button class="icon-button-2">
                                <i class="fas fa-edit mb-1" style="font-size:20px;"></i>
                                <button type="submit" class="icon-button-3 mb-1"><i class="fa fa-trash-o" style="font-size:20px;"></i></button>
                              </button>
                            </form>
                            <!--  -->
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
  {{ $santris->links() }}
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