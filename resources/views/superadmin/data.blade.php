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

              <!-- Main row -->
              <!-- Left col -->
              <!-- /.card -->

              <!-- TABLE: LATEST ORDERS -->
              <div class="card">
                <div class="card-header border-transparent">
                  <h1 class="card-title">
                    <b>Data Santri</b>
                  </h1>
                  <div class="card-tools">
                    <div class="mt-3">
                      <a class="btn btn-primary" href="{{ route('csantri.create') }}">Tambah Santri</a>
                    </div>
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
                            <a class="icon-button-1">
                              <i class="fa fa-print mb-1" href="#" style="font-size:20px;"></i>
                            </a>
                            <a class="icon-button-2" href="{{route('santri.edit', $item->Id_santri)}}">
                              <i class="fas fa-edit mb-1" style="font-size:20px;"></i>
                            </a>
                            <form action="{{ route('santri.destroy', $item->Id_santri) }}" method="post" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="icon-button-3 mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
                                <i class="fa fa-trash-o" style="font-size:20px;"></i>
                              </button>
                            </form>
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