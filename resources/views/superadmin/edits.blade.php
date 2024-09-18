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
              <a href="{{route('pembayaran')}}" class="nav-link">
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

    <div class="content-wrapper">

      <div class="container ml-5">
        <div class="row">
          <div class="col-md-12">
            <h1>Edit Santri</h1>
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

            <form action="{{route('santri.update', ['Id_santri' => $santris])}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card" style="width: 30rem;">
                <div class="card-body">
                  @if ($santris->foto)
                  <img class="mb-1" src="{{ asset('storage/'.$santris->foto) }}" style="width: 100px;">@endif
                  @else
                  <p>Foto tidak tersedia</p>
                  @endif
                  <input type="file" name="foto" id="foto" class="form-control" value="{{ $santris->foto }}">

                  <strong>Nama</strong>
                  <div class="form-group">
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $santris->nama }}">
                  </div>
                  <strong>User</strong>
                  <div class="input-group mb-2">
                    <select class="form-select" for="user_id" id="user_id" name="user_id">
                      @foreach ($user as $user )
                      <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <strong>Tagihan</strong>
                  <div class="input-group mb-2">
                    <label class="input-group-text">Options</label>
                    <select class="form-select col-md-8" for="Tagihan" id="Id_tagihan" name="Id_tagihan">
                      @foreach ($tagihan as $tagihan )
                      <option value="{{$tagihan->Id_tagihan}}">{{$tagihan->Id_tagihan}}</option>
                      @endforeach
                    </select>
                  </div>
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
                  <strong>Tanggal Lahir</strong>
                  <div class="form-group mb-2">
                    <input type="date" id="Tgl_lhr" name="Tgl_lhr" value="{{ $santris->Tgl_lhr }}">
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
                    <input type="text" id="kelas" name="kelas" class="form-control mb-2" value="{{ $santris->kelas }}">
                  </div>
                  <strong>Tingkat</strong>
                  <div class="input-group mb-2">
                    <label class="input-group-text " for="tingkat">Options</label>
                    <select class="form-select col-md-8" id="tingkat" name="tingkat">
                      <option selected>{{ $santris->tingkat }}</option>
                      <option value="MTs">MTs</option>
                      <option value="MA">MA</option>
                      <option value="Salaf">Salaf</option>
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
</body>
@include('dadmin.style')
@include('dadmin.script')