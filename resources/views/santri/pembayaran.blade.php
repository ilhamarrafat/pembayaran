<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cekout</title>
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.Client_Key') }}"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
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
                            <a href="{{url('bayar',auth()->user()->id)}}" class="nav-link active">
                                <i class='nav-icon fas fa-wallet' style='font-size:20px'></i>
                                <p>
                                    Pembayaran
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile.santri')}}" class="nav-link ">
                                <i class="nav-icon far fa-address-card"></i>
                                <p>
                                    Profile
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
                                <i class="nav-icon  fas fa fa-sign-out"></i>
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
        <section>
            <div class="content-wrapper">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <!-- Pembayaran Santri -->
                                <div class="col-md-12">
                                    <div class="card mb-3">
                                        <div class="card-header border-success">
                                            <h4>
                                                <b>PEMBAYARAN SANTRI</b>
                                            </h4>
                                            <form class="row g-3" action="{{ route('pembayaran.index') }}" method="GET">
                                                <div class="col-auto">
                                                    <input class="form-control" type="text" name="search" placeholder="Search" aria-label="default input example" value="{{ request('search') }}">
                                                </div>
                                                <button class="btn btn-primary" type="submit">Cari</button>
                                            </form>
                                            <div class="mt-2">

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <!-- Tabel Tagihan Belum Dibayar -->
                                                <h5>Tagihan Belum Dibayar</h5>
                                                <div class="card-header text-center">
                                                    <h3 class="mb-0">Tagihan untuk Santri: <strong>{{ Auth::user()->name }}</strong></h3>
                                                </div>
                                                <table class="table table-striped table-bordered" id="unpaid-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Tagihan</th>
                                                            <th>Nominal</th>
                                                            <th>Pilih</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($tagihan as $item)
                                                        <tr>
                                                            <td>{{ ++$i }}</td>
                                                            <td>{{ $item->nama_tagihan }}</td>
                                                            <td>Rp.{{ number_format($item->nominal_tagihan, 0, ',', '.') }}</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input checkbox-tagihan"
                                                                        type="checkbox"
                                                                        value="{{ $item->Id_tagihan }}"
                                                                        data-namatagihan="{{ $item->nama_tagihan }}"
                                                                        data-nominal="{{ $item->nominal_tagihan }}">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <h6 class="d-flex justify-content-between mt-3">
                                                    <span>Total Bayar:</span>
                                                    <span id="total_bayar">Rp.0</span>
                                                </h6>


                                                <form method="POST" action="{{ route('cekout') }}" class="mt-4">
                                                    @csrf
                                                    <input type="hidden" name="total_bayar" id="total_bayar_input" value="0">
                                                    <input type="hidden" name="dump_tagihan" id="dump_tagihan">
                                                    <input type="hidden" name="deskripsi" id="dump_nama_tagihan">
                                                    <input type="hidden" name="Id_santri" value="{{ Auth::user()->id }}">

                                                    <button type="submit" class="btn btn-primary btn-block mt-4">Bayar Sekarang</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-footer clearfix">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">View All Orders</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tagihan Santri -->
                                <div class="col-md-12 mt-3">
                                    <div class="card">
                                        <div class="card-header border-success">
                                            <h4>
                                                <b>TAGIHAN SANTRI</b>
                                            </h4>
                                            <form class="row g-4" action="{{ route('pembayaran.index') }}" method="GET">
                                                <div class="col-auto">
                                                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Reset Filter</a>
                                                </div>
                                            </form>
                                            <div class="mt-3">
                                                <a class="btn btn-success" href="{{ route('tagihan.create') }}">Buat Tagihan</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <!-- Tabel Tagihan Sudah Dibayar -->
                                                <h5 class="mt-5">Tagihan Sudah Dibayar</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered" id="paid-table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Tagihan</th>
                                                                <th>Nominal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($paidTagihan as $key => $pembayaranItem)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $pembayaranItem->deskripsi }}</td>
                                                                <td>Rp.{{ number_format($pembayaranItem->total_bayar, 0, ',', '.') }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer clearfix">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">View All Orders</a>
                                        </div>
                                    </div>
                                    {{ $tagihan->links() }}
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let checkboxes = document.querySelectorAll('.checkbox-tagihan');
                                    let totalBayarElement = document.getElementById('total_bayar');
                                    let totalBayarInput = document.getElementById('total_bayar_input');
                                    let dumpTagihanInput = document.getElementById('dump_tagihan');
                                    let dumpNamaTagihanInput = document.getElementById('dump_nama_tagihan');
                                    let total = 0;
                                    let selectedTagihan = [];
                                    let selectedNamaTagihan = [];

                                    checkboxes.forEach(function(checkbox) {
                                        checkbox.addEventListener('change', function() {
                                            let nominal = parseFloat(this.dataset.nominal);
                                            let Id_tagihan = this.value;
                                            let namaTagihan = this.dataset.namatagihan;

                                            if (this.checked) {
                                                total += nominal;
                                                selectedTagihan.push(Id_tagihan);
                                                selectedNamaTagihan.push(namaTagihan);
                                            } else {
                                                total -= nominal;
                                                selectedTagihan = selectedTagihan.filter(id => id !== Id_tagihan);
                                                selectedNamaTagihan = selectedNamaTagihan.filter(nama => nama !== namaTagihan);
                                            }

                                            totalBayarElement.textContent = 'Rp.' + total.toLocaleString();
                                            totalBayarInput.value = total;
                                            dumpTagihanInput.value = JSON.stringify(selectedTagihan);
                                            dumpNamaTagihanInput.value = selectedNamaTagihan.join(', ');
                                        });
                                    });

                                    // Pencarian
                                    const searchInput = document.getElementById('search');
                                    searchInput.addEventListener('keyup', function() {
                                        const filter = this.value.toLowerCase();
                                        filterTable('unpaid-table', filter);
                                    });

                                    function filterTable(tableId, filter) {
                                        const table = document.getElementById(tableId);
                                        const rows = table.getElementsByTagName('tr');

                                        for (let i = 1; i < rows.length; i++) {
                                            const cells = rows[i].getElementsByTagName('td');
                                            let matched = false;

                                            for (let j = 1; j < cells.length; j++) {
                                                if (cells[j].textContent.toLowerCase().includes(filter)) {
                                                    matched = true;
                                                    break;
                                                }
                                            }

                                            rows[i].style.display = matched ? '' : 'none';
                                        }
                                    }
                                });
                            </script>

                            @include('dadmin.style')
                            @include('dadmin.script')
                        </div>
                    </div>
</body>

</html>