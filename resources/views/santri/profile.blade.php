@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <aside class="main-sidebar sidebar-dark-primary mb-20">
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
                        <img src="{{ asset('storage/' . Auth::user()->santri->foto) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
                    </div>
                    <div class="info">
                        <a>Hello,
                            <a>{{ Auth::user()->name }}</a>
                        </a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{route('index.santri')}}" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('bayar',auth()->user()->id)}}" class="nav-link ">
                                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                                <p>
                                    Pembayaran
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile.santri')}}" class="nav-link active">
                                <i class="nav-icon far fa-address-card"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('sktm')}}" class="nav-link">
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
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <section class="content-wrapper">
            <div>
                <div class="container ml-5">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <div class="card" style="width: 30rem;">
                                <div class="card-body">
                                    <h3 class="card-header text-center">
                                        <b>Edit Profile</b>
                                    </h3>

                                    <!-- Display Errors -->
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> Data yang anda inputkan salah!<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <!-- Flash Message -->
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <!-- Edit Form -->
                                    <form method="POST" action="{{ route('santri.update', $santri->Id_santri) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Foto -->
                                        <div class="mb-3 mt-3 text-center">
                                            @if($santri->foto)
                                            <img src="{{ asset('storage/' . $santri->foto) }}" alt="Foto Santri" class="img-thumbnail" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; object-position: top;">
                                            @else
                                            <p>Foto belum diupload.</p>
                                            @endif
                                        </div>
                                        <strong class="mt-3">Upload Foto</strong>
                                        <div class=" input-group mb-3">
                                            <input type="file" placeholder="uploadfile" name="foto" class="form-control" id="foto">
                                        </div>

                                        <!-- Nama -->
                                        <div class="form-group mb-3">
                                            <strong>Nama</strong>
                                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="{{ $santri->nama }}">
                                        </div>

                                        <!-- Jenis Kelamin -->
                                        <strong>Jenis Kelamin</strong>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text col-md-3" for="inputGroupSelect01">Options</label>
                                            <select class="form-select col-md-9" name="Jenis_kelamin" id="Jenis_kelamin">
                                                <option selected>Pilih</option>
                                                <option value="1" {{ $santri->Jenis_kelamin == 1 ? 'selected' : '' }}>Laki-Laki</option>
                                                <option value="2" {{ $santri->Jenis_kelamin == 2 ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>

                                        <!-- Tempat Lahir -->
                                        <div class="form-group mb-3">
                                            <strong>Tempat Lahir</strong>
                                            <input class="form-control" id="Tmp_lhr" name="Tmp_lhr" placeholder="Wonosobo" value="{{ $santri->Tmp_lhr }}">
                                        </div>

                                        <!-- Tanggal Lahir -->
                                        <strong>Tanggal Lahir</strong>
                                        <div class="form-group mb-3">
                                            <input type="date" id="Tgl_lhr" name="Tgl_lhr" class="form-control" value="{{ $santri->Tgl_lhr }}">
                                        </div>

                                        <!-- Alamat -->
                                        <div class="form-group mb-3">
                                            <strong>Alamat</strong>
                                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ $santri->alamat }}</textarea>
                                        </div>

                                        <!-- Tahun Masuk -->
                                        <div class="form-group mb-3">
                                            <strong>Tahun Masuk</strong>
                                            <input type="date" id="Thn_masuk" name="Thn_masuk" class="form-control" value="{{ $santri->Thn_masuk }}">
                                        </div>

                                        <!-- Tahun Keluar -->
                                        <div class="form-group mb-3">
                                            <strong>Tahun Keluar</strong>
                                            <input type="date" id="Thn_keluar" name="Thn_keluar" class="form-control" value="{{ $santri->Thn_keluar }}">
                                        </div>

                                        <!-- Kelas -->
                                        <div class="form-group mb-3">
                                            <strong>Kelas</strong>
                                            <select name="id_kelas" class="form-control">
                                                <option selected disabled>Pilih Kelas</option>
                                                @foreach($kelas as $k)
                                                <option value="{{ $k->id_kelas }}">{{ $k->kelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <strong>Tingkat</strong>
                                            <select name="id_tingkat" class="form-control">
                                                <option selected disabled>Pilih Tingkat</option>
                                                @foreach($tingkat as $t)
                                                <option value="{{ $t->id_tingkat }}">{{ $t->tingkat }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    @include('dadmin.script')
</body>
@include('dadmin.style')
@include('dadmin.script')