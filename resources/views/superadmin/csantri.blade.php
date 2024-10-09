@section('Dashboard','superadmin')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
  <aside class="main-sidebar sidebar-dark-primary mb-20 ">
    <div class="wrapper">
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
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('pembayaran.index')}}" class="nav-link">
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
              <a href="{{route('data')}}" class="nav-link active">
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
  <section>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">

        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
            <div class="card mt-3 ml-5" style="width: 25rem;">
              <div class="card-body">
                <h5 class="card-header text-center"><b>TAMBAH DATA SANTRI</b></h5>
                @if ($errors->any())
                <div class="alert alert-danger">
                  <strong>Whoops!</strong> Ada kesalahan saat anda mengupload<br><br>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                <div class="">
                  @endif
                  @if ($message = Session::get('success'))
                  @endif
                  <form method="POST" action="{{ route('csantri.store') }}" enctype="multipart/form-data">
                    @csrf

                    <strong class="mt-3">Upload Foto</strong>
                    <div class="input-group mb-3">
                      <input type="file" name="foto" class="form-control" id="foto">
                      @error('foto')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Nama</strong>
                      <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}">
                      @error('nama')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Email</strong>
                      <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}">
                      @error('email')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label" value="{{ old('password') }}">Password</label>
                      <input type=" password" class="form-control" name="password" required>
                      @error('password')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Telepon</strong>
                      <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Masukkan No Telepon" value="{{ old('telepon') }}">
                      @error('telepon')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <strong>Jenis Kelamin</strong>
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="inputGroupSelect01">Options</label>
                      <select class="form-select col-md-9" name="Jenis_kelamin" id="Jenis_kelamin">
                        <option value="">Pilih</option>
                        <option value="1" {{ old('Jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="2" {{ old('Jenis_kelamin') == '2' ? 'selected' : '' }}>Perempuan</option>
                      </select>
                      @error('Jenis_kelamin')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Tempat Lahir</strong>
                      <input class="form-control" id="Tmp_lhr" name="Tmp_lhr" placeholder="Wonosobo" value="{{ old('Tmp_lhr') }}">
                      @error('Tmp_lhr')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <strong>Tanggal Lahir</strong>
                    <div class="form-group mb-3">
                      <input type="date" id="Tgl_lhr" name="Tgl_lhr" class="form-control" value="{{ old('Tgl_lhr') }}">
                      @error('Tgl_lhr')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Alamat</strong>
                      <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
                      @error('alamat')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Tahun Masuk</strong>
                      <input type="date" id="Thn_masuk" name="Thn_masuk" class="form-control" value="{{ old('Thn_masuk') }}">
                      @error('Thn_masuk')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Tahun Keluar</strong>
                      <input type="date" id="Thn_keluar" name="Thn_keluar" class="form-control" value="{{ old('Thn_keluar') }}">
                      @error('Thn_keluar')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group mb-3">
                      <strong>Kelas</strong>
                      <select id="kelas" name="id_kelas" class="form-control">
                        @foreach ($kelas as $kelasItem)
                        <option value="{{ $kelasItem->id_kelas }}" {{ old('id_kelas') == $kelasItem->id_kelas ? 'selected' : '' }}>
                          {{ $kelasItem->kelas }}
                        </option>
                        @endforeach
                      </select>
                      @error('id_kelas')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <strong>Tingkat</strong>
                    <div class="input-group mb-3">
                      <label class="input-group-text col-md-3" for="tingkat">Tingkat</label>
                      <select class="form-select col-md-9" id="tingkat" name="id_tingkat"> <!-- Ubah 'name' menjadi 'id_tingkat' -->
                        <option>Pilih</option>
                        @foreach ($tingkat as $tingkatItem)
                        <option value="{{ $tingkatItem->id_tingkat }}" {{ old('id_tingkat') == $tingkatItem->id_tingkat ? 'selected' : '' }}>
                          {{ $tingkatItem->tingkat }}
                        </option>
                        @endforeach
                      </select>
                      @error('id_tingkat') <!-- Ubah di sini juga -->
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>


                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>
  <!-- /.sidebar-menu -->
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