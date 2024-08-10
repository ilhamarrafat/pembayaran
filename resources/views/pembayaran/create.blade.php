@section('Dashboard','superadmin')
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
                            <a href="{{route('dashboard')}}" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pembayaran')}}" class="nav-link active">
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
                            <a href="{{route('data')}}" class="nav-link ">
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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">

                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-12">
                        <div class="card mt-3 ml-5" style="width: 18rem;">
                            <div class="card-body">
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                                <h5 class="card-header text-center"><b>BUAT TAGIHAN</b></h5>
                                <form method="POST" action="{{ route('tagihan.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Tagihan</label>
                                        <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nominal Tagihan</label>
                                        <input type="number" class="form-control" id="nominal_tagihan" name="nominal_tagihan">
                                    </div>
                                    <div class="input-group mb-3">
                                        <label class="mr-5" for="kelas">Kelas</label>
                                        <select class="form-select ml-3 mt-1" id="kelas" name="kelas">
                                            <option selected>Pilih Kelas</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label class="mr-5" for="tingkat">Tingkat</label>
                                        <select class="form-select ml-3 mt-1" id="tingkat" name="tingkat">
                                            <option selected>Pilih Tingkat</option>
                                            <option value="MTs">MTs</option>
                                            <option value="MA">MA</option>
                                            <option value="Salaf">Salaf</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_tagihan" class="form-label">Batas Waktu</label>
                                        <input type="date" class="form-control" id="waktu_tagihan" name="waktu_tagihan">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dadmin.style')
    @include('dadmin.script')
</body>