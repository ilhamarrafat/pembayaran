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
            <img src="{{ asset('foto/' . Auth::user()->admin->foto) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
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
              <a href="{{url('dashboard/superadmin')}}" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('pembayaran')}}" class="nav-link active">
                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                <p>
                  Pembayaran
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('pembayaran')}}" class="nav-link">
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
              <a href="{{route('data')}}" class="nav-link ">
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">

        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
            <div class="col-md-5 mb-10">

            </div>
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-success">
                <h4>
                  <b>
                    PEMBAYARAN SANTRI
                  </b>
                </h4>
                <form class="row g-3">
                  <div class="col-auto">
                    <input class="form-control" type="text" placeholder="Search" aria-label="default input example">
                  </div>
                  <button class="btn btn-primary" type="submit">
                    Cari
                  </button>
                </form>
                <div class="btn btn-success mb-2"><a href=""></a> Cetak Excel</div>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  @include('pembayaran.transaksi')
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            <!-- TABLE: LATEST ORDERS -->
            <!-- /.card -->
          </div>

          <div class="col-md-12 mt-3">
            <div class="col-md-5 mb-10">
            </div>
            <div class="card ">
              <div class="card-header border-success">
                <h4>
                  <b>
                    TAGIHAN SANTRI
                  </b>
                </h4>
                <div>
                  <form class="row g-4" action="{{ route('pembayaran.index') }}" method="GET">
                    <!-- Pencarian berdasarkan nama tagihan -->
                    <div class="col-auto">
                      <input class="form-control" type="text" name="search" placeholder="Cari Nama Tagihan" aria-label="Search" value="{{ request('search') }}">
                    </div>

                    <!-- Filter berdasarkan kelas -->
                    <div class="col-auto">
                      <select class="form-control" name="kelas">
                        <option value="">Filter Kelas</option>
                        @foreach($kelas as $kls)
                        <option value="{{ $kls->id }}" {{ request('kelas') == $kls->id ? 'selected' : '' }}>
                          {{ $kls->nama_kelas }}
                        </option>
                        @endforeach
                      </select>
                    </div>

                    <!-- Filter berdasarkan tingkat -->
                    <div class="col-auto">
                      <select class="form-control" name="tingkat">
                        <option value="">Filter Tingkat</option>
                        @foreach($tingkat as $tkt)
                        <option value="{{ $tkt->id }}" {{ request('tingkat') == $tkt->id ? 'selected' : '' }}>
                          {{ $tkt->nama_tingkat }}
                        </option>
                        @endforeach
                      </select>
                    </div>

                    <!-- Tombol Cari dan Reset -->
                    <div class="col-auto">
                      <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                    <div class="col-auto">
                      <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Reset Filter</a>
                    </div>
                  </form>

                  <!-- Tombol Export dan Buat Tagihan -->
                  <div class="mt-3">
                    <a class="btn btn-success mb-2" href="{{ route('tagihan.create')}}">Buat Tagihan</a>
                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="table-responsive">
                    @include('pembayaran.tagihan')
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                  <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">View All Orders</a>
                </div>
                <!-- /.card-footer -->
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('dadmin.style')
      @include('dadmin.script')
</body>