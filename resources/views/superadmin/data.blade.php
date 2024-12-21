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
            <img src="{{ url('profile/' . Auth::user()->admin->foto) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
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
              <a href="{{route('sdashboard')}}" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('pembayaran.index')}}" class="nav-link ">
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
                  Data
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                <i class="nav-icon fa fa-sign-out"></i>
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



              <!-- Main row -->
              <!-- Left col -->
              <!-- /.card -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-success">
                  <h4>
                    <b>
                      DATA SANTRI
                    </b>
                  </h4>
                  <form class="row g-3 mb-3" method="GET" action="">
                    <div class="col-md-3">
                      <input type="text" name="search_transaksi" class="form-control" placeholder="Cari Nama Santri" value="">
                    </div>
                  </form>
                  <!-- Notifikasi jika data tidak ditemukan -->
                  @if(session('error'))
                  <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                  </div>
                  @endif
                  <div class="mt-3">
                    <a class="btn btn-success" href="{{Route('export_santri')}}">Cetak Excel</a>
                  </div>
                  <div class="mt-3">
                    <a class="btn btn-primary" href="{{ route('csantri.create') }}">Tambah Santri</a>
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
                          <th>Nama Santri</th>
                          <th>Wali Santri</th>
                          <th>Jenis Kelamin</th>
                          <th>Alamat</th>
                          <th>Tempat Lhr</th>
                          <th>Tgl Lahir</th>
                          <th>Tahun Masuk</th>
                          <th>Tahun Keluar</th>
                          <th>Kelas</th>
                          <th>Tingkat</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($santris as $item)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td>
                            @if ($item->foto)
                            <img class="mb-1" src="{{ asset('storage/' . $item->foto) }}" style="width: 50px;">
                            @endif
                          </td>
                          <td>{{$item->nama}}</td>
                          <td>{{$item->wali_santri}}</td>
                          <td>{{$item->Jenis_kelamin}}</td>
                          <td>{{$item->alamat}}</td>
                          <td>{{$item->Tmp_lhr}}</td>
                          <td>{{$item->Tgl_lhr}}</td>
                          <td>{{$item->Thn_masuk}}</td>
                          <td>{{$item->Thn_keluar}}</td>
                          <td>{{ $item->id_kelas}}</td>
                          <td>{{ $item->id_tingkat}}</td>
                          <td>{{ $item->status}}</td>
                          <td>
                            <!-- Tombol print -->
                            <a href="{{ route('exportdatapdf', $item->Id_santri) }}">
                              <button class="icon-button-1">
                                <i class="fa fa-print mb-1" style="font-size:20px;"></i>
                              </button>
                            </a>
                            <!-- Tombol edit -->
                            <a href="{{ route('santri_edit', $item->Id_santri) }}"
                              class="icon-button-2"
                              onclick="return confirmEdit(event);">
                              <i class="fas fa-edit mb-1" style="font-size:20px;"></i>
                            </a>
                            <!-- Tombol hapus -->
                            <form action="{{ route('santri_destroy', $item->Id_santri) }}" method="post" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit"
                                class="icon-button-3 mb-1"
                                onclick="return confirmDelete(event);">
                                <i class="fa fa-trash-o" style="font-size:20px;"></i>
                              </button>
                            </form>
                          <td>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                    <!-- Tautan navigasi paginasi -->
                    <nav aria-label="Page navigation example">
                      <div>
                        {{ $santris->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
                      </div>
                    </nav>
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
  <script>
    function confirmEdit(event) {
      event.preventDefault(); // Mencegah aksi default navigasi
      const confirmation = confirm("Apakah Anda yakin ingin mengedit data ini?");
      if (confirmation) {
        // Jika pengguna mengkonfirmasi, lanjutkan ke URL edit
        window.location.href = event.currentTarget.href;
      }
    }

    function confirmDelete(event) {
      const confirmation = confirm("Apakah Anda yakin ingin menghapus data ini?");
      if (!confirmation) {
        event.preventDefault(); // Mencegah pengiriman form jika pengguna membatalkan
      }
    }
  </script>

</body>
@include('dadmin.style')
@include('dadmin.script')