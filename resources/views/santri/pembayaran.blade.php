<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Midtrans Snap.js -->
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.Client_Key') }}"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Navbar -->
    @include('dadmin.navbar')

    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{asset('template/assets/img/logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Dashboard</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- User Panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('storage/' . Auth::user()->santri->foto) }}" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; object-position: top;">
                    </div>
                    <div class="info">
                        <a>Hello, {{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{route('index.santri')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('bayar',auth()->user()->id)}}" class="nav-link active">
                                <i class="nav-icon fas fa-wallet" style="font-size:20px"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('profile_santri')}}" class="nav-link">
                                <i class="nav-icon far fa-address-card"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/gallery.html" class="nav-link">
                                <i class="nav-icon fa fa-envelope"></i>
                                <p>Ajuan Keterlambatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <!-- Pembayaran Santri -->
                            <div class="col-md-12 mt-3">
                                @include('santri.tagihan')
                            </div>
                            <!-- Tagihan yang Dibayar -->
                            <div class="col-md-12 mt-3">
                                @include('santri.dibayar')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
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
                    let idTagihan = this.value;
                    let namaTagihan = this.dataset.namatagihan;

                    if (this.checked) {
                        total += nominal;
                        selectedTagihan.push(idTagihan);
                        selectedNamaTagihan.push(namaTagihan);
                    } else {
                        total -= nominal;
                        selectedTagihan = selectedTagihan.filter(id => id !== idTagihan);
                        selectedNamaTagihan = selectedNamaTagihan.filter(nama => nama !== namaTagihan);
                    }

                    totalBayarElement.textContent = 'Rp.' + total.toLocaleString();
                    totalBayarInput.value = total;
                    dumpTagihanInput.value = JSON.stringify(selectedTagihan);
                    dumpNamaTagihanInput.value = selectedNamaTagihan.join(', ');
                });
            });

            // Search Filter
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
</body>

</html>