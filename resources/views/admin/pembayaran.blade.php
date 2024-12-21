@section('Dashboard','admin')
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
                            <a href="{{route('pembayaran_santri')}}" class="nav-link active">
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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header border-success">
                                <h4>
                                    <b>
                                        PEMBAYARAN SANTRI
                                    </b>
                                </h4>
                                <form class="row gy-2 gx-3 align-items-center mb-4" method="GET" action="{{ route('pembayaran_santri') }}">
                                    <div class="col-md-3">
                                        <label for="search_transaksi" class="form-label">Cari Nama Santri</label>
                                        <input type="text" id="search_transaksi" name="search_transaksi" class="form-control" placeholder="Nama Santri" value="{{ request('search_transaksi') }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="kelas_tagihan" class="form-label">Filter Kelas</label>
                                        <select id="kelas_tagihan" name="kelas_tagihan" class="form-control">
                                            <option value="">-- Pilih Kelas --</option>
                                            @foreach($kelas as $k)
                                            <option value="{{ $k->id_kelas }}" {{ request('kelas_tagihan') == $k->id_kelas ? 'selected' : '' }}>
                                                {{ $k->kelas }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tingkat_tagihan" class="form-label">Filter Tingkat</label>
                                        <select id="tingkat_tagihan" name="tingkat_tagihan" class="form-control">
                                            <option value="">-- Pilih Tingkat --</option>
                                            @foreach($tingkat as $t)
                                            <option value="{{ $t->id_tingkat }}" {{ request('tingkat_tagihan') == $t->id_tingkat ? 'selected' : '' }}>
                                                {{ $t->tingkat }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status_transaksi" class="form-label">Status Transaksi</label>
                                        <select id="status_transaksi" name="status_transaksi" class="form-control">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="paid" {{ request('status_transaksi') == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="unpaid" {{ request('status_transaksi') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="search_tagihan" class="form-label">Cari Nama Tagihan</label>
                                        <input type="text" id="search_tagihan" name="search_tagihan" class="form-control" placeholder="Nama Tagihan" value="{{ request('search_tagihan') }}">
                                    </div>
                                    <div class="col-auto mt-4">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="{{ route('pembayaran_santri') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </form>
                                <!-- Notifikasi jika data tidak ditemukan -->
                                @if(session('error'))
                                <div class="alert alert-danger mt-3">
                                    {{ session('error') }}
                                </div>
                                @endif
                                <div class="mt-3">
                                    <a class="btn btn-success" href="{{Route('export_transaksi')}}">Cetak Excel</a>
                                </div>
                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-bordered">
                                        <thead class="middle">
                                            <tr>
                                                <th>Nomor Transaksi</th>
                                                <th>Nama Santri</th>
                                                <th>Jumlah Pembayaran</th>
                                                <th>Metode Pembayaran</th>
                                                <th>Tanggal Pembayaran</th>
                                                <th>Status Transaksi</th>
                                                <th>Deskripsi Transaksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach ($transaksis as $transaksi)
                                            <tr>
                                                <td>{{ $transaksi->id_transaksi }}</td>
                                                <td>{{ $transaksi->santri ? $transaksi->santri->nama : 'Santri tidak ditemukan' }}</td> <!-- Null check -->
                                                <td>{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td> <!-- Format jumlah pembayaran -->
                                                <td>{{ $transaksi->jenis_pembayaran }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->format('d-m-Y H:i') }}</td> <!-- Format tanggal -->
                                                <td>
                                                    <span class="badge {{ $transaksi->status_transaksi == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($transaksi->status_transaksi) }}
                                                    </span>
                                                </td>
                                                <td>{{ $transaksi->deskripsi }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <nav aria-label="Page navigation example">
                                    <div>
                                        {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
                                    </div>
                                </nav>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">View All Orders</a>
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
                                    <form class="row g-3 mb-4" method="GET" action="{{ route('pembayaran_santri') }}">
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
                                            <a href="{{ route('pembayaran_santri') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </form>
                                    <!-- Tombol Export dan Buat Tagihan -->
                                    <div>
                                        <div class="mt-3 mb-3">
                                            <a href="{{ route('tagihan.export', request()->all()) }}" class="btn btn-success">Export Tagihan</a>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Tagihan</th>
                                                        <th>Nominal Tagihan</th>
                                                        <th>Batas Waktu</th>
                                                        <th>Kelas</th>
                                                        <th>Tingkat</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $no = 1;
                                                    @endphp
                                                    @foreach($tagihans as $tag)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $tag->nama_tagihan }}</td>
                                                        <td>Rp. {{ number_format($tag->nominal_tagihan, 0, ',', '.') }}</td>
                                                        <td>{{ $tag->waktu_tagihan }}</td>
                                                        <td>{{ $tag->id_kelas }}</td>
                                                        <td>{{ $tag->id_tingkat }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Pagination Links -->
                                    <nav aria-label="Page navigation example">
                                        <div>
                                            {{ $tagihans->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
                                        </div>
                                    </nav>
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