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
              <a href="{{route('pembayaran.index')}}" class="nav-link active">
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
              <a href="{{route('data')}}" class="nav-link">
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
                <h4><b>PEMBAYARAN SANTRI</b></h4>

                <form class="row g-3 mb-4" method="GET" action="{{ route('pembayaran.index') }}">
                  <div class="col-md-3">
                    <input type="text" name="search_transaksi" class="form-control" placeholder="Cari Nama Santri" value="{{ request('search_transaksi') }}">
                  </div>
                  <div class="col-md-3">
                    <select name="status_transaksi" class="form-control">
                      <option value="">-- Filter Status --</option>
                      <option value="paid" {{ request('status_transaksi') == 'paid' ? 'selected' : '' }}>Paid</option>
                      <option value="unpaid" {{ request('status_transaksi') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                  </div>
                  <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Reset</a>
                  </div>
                </form>

                @if(session('error'))
                <div class="alert alert-danger mt-3">
                  {{ session('error') }}
                </div>
                @endif

                <div class="mt-3">
                  <a class="btn btn-success" href="{{ route('export_tagihan') }}">Cetak Excel</a>
                </div>
              </div>

              @include('pembayaran.transaksi')

              <div class="card-footer clearfix">

              </div>
            </div>
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
                  <form class="row g-3 mb-4" method="GET" action="{{ route('pembayaran.index') }}">
                    <div class="col-md-3">
                      <input type="text" name="search_tagihan" class="form-control" placeholder="Cari Nama Tagihan" value="{{ request('search_tagihan') }}">
                    </div>
                    <div class="col-md-3">
                      <select name="kelas_tagihan" class="form-control">
                        <option value="">-- Filter Kelas --</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id_kelas }}" {{ request('kelas_tagihan') == $k->id_kelas ? 'selected' : '' }}>
                          {{ $k->kelas }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-3">
                      <select name="tingkat_tagihan" class="form-control">
                        <option value="">-- Filter Tingkat --</option>
                        @foreach($tingkat as $t)
                        <option value="{{ $t->id_tingkat }}" {{ request('tingkat_tagihan') == $t->id_tingkat ? 'selected' : '' }}>
                          {{ $t->tingkat }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-auto">
                      <button type="submit" class="btn btn-primary">Cari</button>
                      <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                  </form>

                  <!-- Tombol Export dan Buat Tagihan -->
                  <div>
                    <div class="mt-3 mb-3">
                      <a href="{{ route('tagihan_export', request()->all()) }}" class="btn btn-success">Export Tagihan</a>
                      <a class="btn btn-primary" href="{{ route('tagihan.create')}}">Buat Tagihan</a>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  @include('pembayaran.tagihan')
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
          </div>
        </div>
        @include('dadmin.style')
        @include('dadmin.script')
        <script>
          // Validasi tombol print
          function confirmPrint(event) {
            event.preventDefault(); // Mencegah aksi default tombol
            const confirmation = confirm("Apakah Anda yakin ingin mencetak data ini?");
            if (confirmation) {
              console.log("Proses mencetak...");
              // Tambahkan logika cetak jika diperlukan
              return true; // Lanjutkan aksi jika dikonfirmasi
            }
            return false; // Batalkan aksi jika tidak dikonfirmasi
          }

          // Validasi tombol edit
          function confirmEdit(event) {
            event.preventDefault(); // Mencegah navigasi default
            const confirmation = confirm("Apakah Anda yakin ingin mengedit data ini?");
            if (confirmation) {
              window.location.href = event.currentTarget.href; // Lanjutkan navigasi
            }
          }

          // Validasi tombol hapus
          function confirmDelete(event) {
            const confirmation = confirm("Apakah Anda yakin ingin menghapus tagihan ini?");
            if (!confirmation) {
              event.preventDefault(); // Batalkan penghapusan jika tidak dikonfirmasi
            }
          }
        </script>

</body>