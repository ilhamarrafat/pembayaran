@section('Dashboard','superadmin')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('superadmin.sidebar')
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
                            <!-- Tombol print -->
                            <button class="icon-button-1">
                              <i class="fa fa-print mb-1" style="font-size:20px;"></i>
                            </button>
                            <!-- Tombol edit -->
                            <a href="{{route('santri.edit', $item->Id_santri)}}" class="icon-button-2">
                              <i class="fas fa-edit mb-1" style="font-size:20px;"></i>
                            </a>
                            <!-- Tombol hapus -->
                            <form action="{{ route('santri.destroy', $item->Id_santri) }}" method="post" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="icon-button-3 mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
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
                        {{ $santri->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
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