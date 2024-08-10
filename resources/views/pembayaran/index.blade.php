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
              <a href="{{route('dashboard')}}" class="nav-link ">
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
              <a href="#" class="nav-link">
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
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-success">
                <h4>
                  <b>
                    PEMBAYARAN SANTRI
                  </b>
                </h4>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table  table-bordered">
                    <thead class="middle">
                      <tr>
                        <th>Nomor Transaksi</th>
                        <th>Nama Santri</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Status Transaksi</th>
                        <th>Deskripsi Transaksi</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="table-group-divider">
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                          <a href="">Lihat Detail</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            <!-- TABLE: LATEST ORDERS -->
            <!-- /.card -->
          </div>
          <div class="col-md-12 mt-3">
            <div class="card ">
              <div class="card-header border-success">
                <h4>
                  <b>
                    TAGIHAN SANTRI
                  </b>
                </h4>
                <button class="btn btn-info float-right">
                  <a href="{{route('tagihan.create')}}">
                  </a>
                  Buat Tagihan
                </button>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="middle">
                      <tr>
                        <th>No</th>
                        <th>Nama Tagihan</th>
                        <th>Nominal Tagihan</th>
                        <th>Batas Waktu</th>
                        <th>Kelas</th>
                        <th>Tingkat</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody class="table-group-divider">
                      @foreach($tagihan as $item)
                      <tr>
                        <td>{{$item->Id_tagihan }}</td>
                        <td>{{$item->nama_tagihan}}</td>
                        <td>{{$item->nominal_tagihan}}</td>
                        <td>{{$item->waktu_tagihan}}</td>
                        @endforeach
                        @foreach($santri as $santri)
                        <td>{{$santri->kelas}}</td>
                        <td>{{$santri->tingkat}}</td>
                        @endforeach
                        <td>
                          <a href="">Lihat Detail</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
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