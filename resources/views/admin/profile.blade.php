@section('Dashboard','superadmin')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Sidebar -->
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
                        <img src="{{ asset('foto/' . Auth::user()->admin) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
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
                            <a href="{{url('dashboard/admin')}}" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('pembayaran_santri')}}" class="nav-link ">
                                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                                <p>
                                    Pembayaran
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('berita_show')}}" class="nav-link">
                                <i class="nav-icon fa fa-newspaper-o" style="font-size:20px"></i>
                                <p>
                                    Berita
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile_admin')}}" class="nav-link">
                                <i class="nav-icon far fa-address-card"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('data_santri')}}" class="nav-link active">
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
        <section class="content-wrapper">
            <div>
                <div class="container ml-5">
                    <div class="row">
                        <div class="col-md-12 mt-2 ">
                            <h1>Edit Profile</h1>

                            @foreach($admins as $admin)
                            <form action="{{ route('profile_update_admin', $admin->id_admin) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        @if($admin->foto)
                                        <img src=" {{ url('foto/'.$admin->foto) }}" style="width: 100px;" class="card-img-top mb-2" alt="...">
                                        @else
                                        <p>No photo available</p>
                                        @endif


                                        <div class="input-group">
                                            <input type="file" name="foto" class="form-control" id="foto">
                                            <label class="input-group-text mb-2" for="foto">Upload</label>
                                        </div>
                                        <h5 class="card-title">Nama</h5>
                                        <div class="">
                                            <input class="form-control mb-2" id="nama" name="nama" value="{{Auth::user()->name}}">
                                        </div>
                                        <h5 class="card-title">Email</h5>
                                        <div class="">
                                            <input class="form-control mb-2" id="email" name="email" value="">
                                        </div>
                                        <h5 class="card-title">Password</h5>
                                        <div class="">
                                            <input class="form-control mb-2" id="password" name="password" value="">
                                        </div>
                                        <button type="submit" class="mt-2 btn btn-primary">Submit</button>
                                        @endforeach
                            </form>
                        </div>
        </section>
        <!-- /.sidebar -->
        <!-- /.card -->
    </div>
    <!-- Tautan navigasi paginasi -->
</body>
<!-- Content Wrapper. Contains page content -->
@include('dadmin.style')
@include('dadmin.script')