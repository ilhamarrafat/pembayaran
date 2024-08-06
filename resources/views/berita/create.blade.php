
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
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
                <li class="nav-item">
                  <a href="{{route('pembayaran')}}" class="nav-link">
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
              <a href="#" class="nav-link">
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

        <div class="content-wrapper">
    
        <div class="container ml-5">
      <div class="row">
          <div class="col-md-12 mt-2 ">
              <h1>Tambah Berita</h1>
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
              <form method="POST" action="{{ route('berita.store') }}" enctype="multipart/form-data" >
                @csrf
                @method('POST')
                  <strong>Upload Foto</strong>
                  <div class="input-group mb-2 col-md-8">
                      <input type="file" placeholder="uploadfile" name="gambar" class="form-control" id="gambar">
                      <label class="input-group-text"  for="gambar">Upload</label>
                  </div>
                  <div class="form-group mb-2 col-md-8">
                      <strong>Judul</strong>
                      <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul">
                  </div>
                  <div class="form-group mb-2 col-md-8">
                      <strong>Isi</strong>
                      <input type="file" placeholder="uploadfile" name="isi" class="form-control" id="isi">
                      <label class="input-group-text"  for="isi">Upload</label>
                    </div>
                  <button type="submit" class="btn btn-primary mt-3">Submit</button>
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