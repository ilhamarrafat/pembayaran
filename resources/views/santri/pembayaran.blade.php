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
                        <a href="" class="nav-link ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('bayar')}}" class="nav-link active">
                            <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                            <p>
                                Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="nav-icon far fa-address-card"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link ">
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
                        <div class="card" style="width: 25rem;">
                            <div class="card-body">
                                <h3 class="card-header text-center">
                                    <B>PEMBAYARAN</B>
                                </h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pembayaran</th>
                                            <th>Nominal</th>
                                            <th>List</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tagihan as $tag)
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{$tag->nama_tagihan}}</td>
                                            <td>{{$tag->nominal_tagihan}}</td>
                                            <td>
                                                @endforeach
                                                <div class="col-sm-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-success mt-3">Bayar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
@include('dadmin.style')
@include('dadmin.script')