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
                                <form method="POST" action="{{route('tagihan.store')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama Tagihan</label>
                                        <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nominal Tagihan</label>
                                        <input type="text" class="form-control" id="nominal_tagihan" name="nominal_tagihan">
                                    </div>
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
                                    <div class="mb-3">
                                        <label for="waktu_tagihan" class="form-label">Batas Waktu</label>
                                        <input type="date" class="form-control" id="waktu_tagihan" name="waktu_tagihan">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                                <script>
                                    function formatRupiah(angka, prefix) {
                                        var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                            split = number_string.split(','),
                                            sisa = split[0].length % 3,
                                            rupiah = split[0].substr(0, sisa),
                                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                                        if (ribuan) {
                                            separator = sisa ? '.' : '';
                                            rupiah += separator + ribuan.join('.');
                                        }

                                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                                    }

                                    document.getElementById('nominal_tagihan').addEventListener('keyup', function(e) {
                                        this.value = formatRupiah(this.value, 'Rp. ');
                                    });
                                </script>

                            </div>
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