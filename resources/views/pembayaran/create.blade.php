@section('Dashboard','superadmin')
@include('dadmin.navbar')

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <aside class="main-sidebar sidebar-dark-primary mb-20 ">
            <!-- Brand Logo -->
            <a href="{{url('/')}}" class="brand-link">
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
                            <a href="{{route('pembayaran.index')}}" class="nav-link active">
                                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                                <p>
                                    Pembayaran
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('berita')}}" class="nav-link ">
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

                                @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif

                                <h5 class="card-header text-center"><b>BUAT TAGIHAN</b></h5>
                                <form method="POST" action="{{route('tagihan.store')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama Tagihan</label>
                                        <input type="text" class="form-control" id="nama_tagihan" name="nama_tagihan">
                                        @error('nama_tagihan')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                        <label class="form-label">Periode Tagihan</label>
                                        <div class="form-group">
                                            <!-- Opsi Tagihan Sekali -->
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="periode_tagihan"
                                                    id="satu_periode"
                                                    value="satu_periode"
                                                    checked>
                                                <label class="form-check-label" for="satu_periode">
                                                    Tagihan Sekali
                                                </label>
                                                <small class="text-muted d-block">Tagihan hanya berlaku satu kali pada periode yang dipilih.</small>
                                            </div>

                                            <!-- Opsi Tagihan Setiap Bulan -->
                                            <div class="form-check mt-2">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    name="periode_tagihan"
                                                    id="per_periode"
                                                    value="per_periode">
                                                <label class="form-check-label" for="per_periode">
                                                    Satu Tahun (Setiap Bulan)
                                                </label>
                                                <small class="text-muted d-block">Tagihan akan dibuat untuk setiap bulan dalam satu tahun.</small>
                                            </div>
                                        </div>

                                        <!-- Validasi Error -->
                                        @error('periode_tagihan')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
    </div>
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

        // Format otomatis untuk nominal tagihan
        document.querySelector('#nominal_tagihan').addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value, 'Rp. ');
        });

        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const namaTagihan = document.querySelector('input[name="nama_tagihan"]').value.trim();
            const nominalTagihanInput = document.querySelector('input[name="nominal_tagihan"]').value.trim();
            const waktuTagihan = document.querySelector('input[name="waktu_tagihan"]').value.trim();
            const periode_tagihan = document.querySelector('input[name="periode_tagihan"]:checked');

            console.log({
                namaTagihan,
                nominalTagihanInput,
                waktuTagihan,
                periode_tagihan
            });

            const nominalTagihan = nominalTagihanInput.replace(/[^0-9]/g, '');

            if (!namaTagihan) {
                e.preventDefault();
                alert('Nama Tagihan wajib diisi!');
                return;
            }

            if (!nominalTagihan || isNaN(nominalTagihan) || nominalTagihan < 1000) {
                e.preventDefault();
                alert('Nominal tagihan harus berupa angka minimal Rp. 1.000');
                return;
            }

            if (!waktuTagihan) {
                e.preventDefault();
                alert('Waktu Tagihan wajib diisi!');
                return;
            }

            if (!periode_tagihan) {
                e.preventDefault();
                alert('Silakan pilih Periode Tagihan!');
                return;
            }
        });
    </script>
    @include('dadmin.style')
    @include('dadmin.script')
</body>