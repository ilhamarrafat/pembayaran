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
              <a href="{{route('berita')}}" class="nav-link active">
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
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="row justify-content-center">
          <!-- Left col -->
          <div class="col-md-8">
            <div class="card mt-5 shadow-lg" style="border-radius: 10px;">
              <div class="card-body p-4">
                <h3 class="card-header text-center bg-primary text-white mb-4" style="border-radius: 10px;">
                  <b>TAMBAH BERITA</b>
                </h3>

                <!-- Error Display -->
                @if ($errors->any())
                <div class="alert alert-danger">
                  <strong>Whoops!</strong> Ada kesalahan saat anda mengupload<br><br>
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

                <!-- Form -->
                <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data">
                  @csrf
                  @method('POST')

                  <!-- Upload Foto -->
                  <div class="mb-3">
                    <label for="gambar" class="form-label"><strong>Upload Foto</strong></label>
                    <input type="file" name="gambar" class="form-control" id="gambar" required>
                  </div>

                  <!-- Judul Berita -->
                  <div class="mb-3">
                    <label for="judul" class="form-label"><strong>Judul</strong></label>
                    <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul Berita" required>
                  </div>

                  <!-- Isi Berita -->
                  <div class="mb-3">
                    <label for="isi" class="form-label"><strong>Isi Berita</strong></label>
                    <textarea name="isi" class="form-control" id="isi" rows="5" placeholder="Isi berita" required></textarea>
                  </div>

                  <!-- Submit Button -->
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3" style="width: 100px;">Submit</button>
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