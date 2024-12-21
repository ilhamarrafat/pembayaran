@section('Dashboard','superadmin')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
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
  <section>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="row justify-content-center">
          <!-- Main container for the form -->
          <div class="col-md-10">
            <div class="card shadow-lg mt-5">
              <div class="card-header bg-primary text-white text-center shadow-sm">
                <h5><b>TAMBAH DATA SANTRI</b></h5>
              </div>
              <div class="card-body">
                <!-- Error Messages -->
                @if ($errors->any())
                <div class="alert alert-danger">
                  <strong>Whoops!</strong> Ada kesalahan saat Anda mengisi formulir.<br><br>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif

                <!-- Success Message -->
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                  {{ $message }}
                </div>
                @endif

                <form method="POST" action="{{ route('csantri.store') }}" enctype="multipart/form-data">
                  @csrf

                  <!-- Form row starts here -->
                  <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">

                      <!-- Upload Foto -->
                      <div class="form-group mb-3">
                        <label for="foto"><strong>Upload Foto</strong></label>
                        <input type="file" name="foto" class="form-control" id="foto">
                        @error('foto')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Nama -->
                      <div class="form-group mb-3">
                        <label for="nama"><strong>Nama</strong></label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}">
                        @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <!-- Nama wali -->
                      <div class="form-group mb-3">
                        <label for="wali_santri"><strong>Nama Wali</strong></label>
                        <input type="text" id="wali_santri" name="wali_santri" class="form-control" placeholder="Masukkan Nama Lengkap" value="{{ old('wali_santri') }}">
                        @error('wali_santri')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Email -->
                      <div class="form-group mb-3">
                        <label for="email"><strong>Email</strong></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" value="" autocomplete="off">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Password -->
                      <div class="form-group mb-3 position-relative">
                        <label for="password"><strong>Password</strong></label>
                        <div class="input-group">
                          <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                          <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                          </span>
                        </div>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Tombol untuk generate password acak -->
                      <div class="form-group mb-3">
                        <button type="button" class="btn btn-primary" onclick="generatePassword()">Generate Random Password</button>
                      </div>


                      <!-- Telepon -->
                      <div class="form-group mb-3">
                        <label for="telepon"><strong>Telepon</strong></label>
                        <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Masukkan No Telepon" value="{{ old('telepon') }}">
                        @error('telepon')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="Jenis_kelamin"><strong>Kelas</strong></label>
                        <select id="Jenis_kelamin" name="Jenis_kelamin" class="form-control">
                          <option value="1" {{ old('Jenis_kelamin') == '1' ? 'selected' : '' }}>Laki-Laki</option>
                          <option value="2" {{ old('Jenis_kelamin') == '2' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('Jenis_kelamin')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">

                      <!-- Tempat Lahir -->
                      <div class="form-group mb-3">
                        <label for="Tmp_lhr"><strong>Tempat Lahir</strong></label>
                        <input type="text" id="Tmp_lhr" name="Tmp_lhr" class="form-control" placeholder="Masukkan Tempat Lahir" value="{{ old('Tmp_lhr') }}">
                        @error('Tmp_lhr')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Tanggal Lahir -->
                      <div class="form-group mb-3">
                        <label for="Tgl_lhr"><strong>Tanggal Lahir</strong></label>
                        <input type="date" id="Tgl_lhr" name="Tgl_lhr" class="form-control" value="{{ old('Tgl_lhr') }}">
                        @error('Tgl_lhr')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Alamat -->
                      <div class="form-group mb-3">
                        <label for="alamat"><strong>Alamat</strong></label>
                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Tahun Masuk -->
                      <div class="form-group mb-3">
                        <label for="Thn_masuk"><strong>Tahun Masuk</strong></label>
                        <input type="date" id="Thn_masuk" name="Thn_masuk" class="form-control" value="{{ old('Thn_masuk') }}">
                        @error('Thn_masuk')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Kelas -->
                      <div class="form-group mb-3">
                        <label for="kelas"><strong>Kelas</strong></label>
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

                      <!-- Tingkat -->
                      <div class="form-group mb-3">
                        <label for="tingkat"><strong>Kelas</strong></label>
                        <select id="tingkat" name="id_tingkat" class="form-control">
                          @foreach ($tingkat as $tingkatItem)
                          <option value="{{ $tingkatItem->id_tingkat }}" {{ old('id_tingkat') == $tingkatItem->id_tingkat ? 'selected' : '' }}>
                            {{ $tingkatItem->tingkat }}
                          </option>
                          @endforeach
                        </select>
                        @error('id_tingkat')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="form-group mb-3">
                        <label for="status"><strong>Status Santri</strong></label>
                        <select id="status" name="status" class="form-control">
                          <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                          <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>

                      <!-- Submit Button -->
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
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

    // Fungsi untuk generate password acak
    function generatePassword() {
      const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
      let randomPassword = "";
      for (let i = 0; i < 12; i++) {
        randomPassword += charset.charAt(Math.floor(Math.random() * charset.length));
      }
      document.getElementById('password').value = randomPassword;
    }
  </script>
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