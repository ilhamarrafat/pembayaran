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
  <section>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="row justify-content-center">
          <!-- Main container for the form -->
          <div class="col-md-10">
            <div class="card shadow-lg mt-5">
              <div class="card-header bg-primary text-white text-center shadow-sm">
                <h5><b>EDIT DATA SANTRI</b></h5>
              </div>
              <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif

                <form action="{{route('santri_update', ['Id_santri' => $santris])}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <!-- Form row starts here -->
                  <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                      @if ($santris->foto)
                      <img class="mb-1" src="{{ asset('storage/'.$santris->foto) }}" style="width: 100px;">
                      @else
                      <p>Foto tidak tersedia</p>
                      @endif
                      <input type="file" name="foto" id="foto" class="form-control" value="{{ $santris->foto }}">

                      <div class="form-group mb-3">
                        <label for="nama"><strong>Nama</strong></label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $santris->nama) }}" required>
                        @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="wali_santri"><strong>Nama Wali</strong></label>
                        <input type="text" name="wali_santri" id="wali_santri" class="form-control" value="{{ old('wali_santri', $santris->wali_santri) }}" required>
                        @error('wali_santri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <!-- Email -->
                      <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $santri->user->email ?? '') }}">
                      </div>

                      <div class="form-group mb-3 position-relative">
                        <label for="password"><strong>Password</strong></label>
                        <div class="input-group">
                          <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
                          <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                          </span>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Konfirmasi Password -->
                      <div class="form-group mb-3">
                        <label for="password_confirmation"><strong>Konfirmasi Password</strong></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                      </div>
                      <!--  -->
                      <!-- jenis kelamin -->
                      <strong>Jenis Kelamin</strong>
                      <div class="input-group mb-2">
                        <label class="input-group-text">Options</label>
                        <select class="form-select col-md-8" for="inputGroupSelect01" name="Jenis_kelamin" id="Jenis_kelamin">
                          <option selected>{{ $santris->Jenis_kelamin }}</option>
                          <option value="1">Laki-Laki</option>
                          <option value="2">Perempuan</option>
                        </select>
                      </div>
                      <div class="form-group mb-2">
                        <strong>Tempat Lahir</strong>
                        <input class="form-control" id="Tmp_lhr" name="Tmp_lhr" value="{{ $santris->Tmp_lhr }}">
                      </div>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6">

                      <div class="form-group mb-2">
                        <label for="Tgl_lhr"><strong>Tanggal Lahir</strong></label>
                        <input type="date" id="Tgl_lhr" name="Tgl_lhr" class="form-control mb-2" value="{{ $santris->Tgl_lhr }}">
                      </div>
                      <strong>Alamat</strong>
                      <div class="form-group mb-2">
                        <textarea class="form-control " id="alamat" name="alamat">{{ $santris->alamat }}</textarea>
                      </div>
                      <strong>Tahun Masuk</strong>
                      <div class="form-group mb-2">
                        <input type="date" id="Thn_masuk" name="Thn_masuk" class="form-control mb-2" value="{{ $santris->Thn_masuk }}">
                      </div>
                      <strong>Tahun Keluar</strong>
                      <div class="form-group mb-2">
                        <input type="date" id="Thn_keluar" name="Thn_keluar" class="form-control mb-2" value="{{ $santris->Thn_keluar }}">
                      </div>
                      <strong>Kelas</strong>
                      <div class="form-group mb-2">
                        <select name="id_kelas" class="form-control" required>
                          @foreach ($kelas as $kelas_item)
                          <option value="{{ $kelas_item->id_kelas }}"
                            {{ $kelas_item->id_kelas == $santris->id_kelas ? 'selected' : '' }}>
                            {{ $kelas_item->kelas }}
                          </option>
                          @endforeach
                        </select>
                      </div>

                      <!-- Tingkat -->
                      <strong>Tingkat</strong>
                      <div class="form-group mb-2">
                        <select name="id_tingkat" class="form-control" required>
                          @foreach ($tingkat as $tingkat_item)
                          <option value="{{ $tingkat_item->id_tingkat }}"
                            {{ $tingkat_item->id_tingkat == $santris->id_tingkat ? 'selected' : '' }}>
                            {{ $tingkat_item->tingkat }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <strong>Status</strong>
                      <div class="input-group mb-2">
                        <label class="input-group-text">Options</label>
                        <select class="form-select col-md-8" for="inputGroupSelect01" name="status" id="status">
                          <option selected>{{ $santris->status }}</option>
                          <option value="1">Aktif</option>
                          <option value="2">Tidak Aktif</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
  </section>
  <!-- /.sidebar-menu -->
  </div>
  </div>
  <script>
    // Fungsi untuk toggle visibilitas password
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
@include('dadmin.style')
@include('dadmin.script')