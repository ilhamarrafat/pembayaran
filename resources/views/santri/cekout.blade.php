<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{config('midtrans.Client_Key')}}">
    </script>
    <title>Cekout</title>
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
        <section>
            <div class="content-wrapper">

                <div class="container ml-5">
                    <div class="row">
                        <div class="col-md-12 mt-2 ">
                            <div class="card" style="width: 25rem;">
                                <div class="card-body">
                                    <table class="table table-bordered border-primary">
                                        <h3 class="card-header text-center">
                                            Tagihan untuk Santri:
                                            <b>{{Auth::user()->name}}</b>
                                        </h3>
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama Tagihan</th>
                                                <th scope="col">Total Bayar</th>
                                                <th scope="col">Status Transaksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> {!! $transaksi->deskripsi !!}</td>
                                                <td>Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                                <td>{!! $transaksi->status_transaksi !!}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div>
                                        <button type="submit" class="btn btn-success mt-3" id="pay-button">Bayar Sekarang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let checkboxes = document.querySelectorAll('.checkbox-tagihan');
            let totalBayarElement = document.getElementById('total_bayar');
            let totalBayarInput = document.getElementById('total_bayar_input');
            let dumpTagihanInput = document.getElementById('dump_tagihan');
            let total = 0;
            let selectedTagihan = [];

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let nominal = parseFloat(this.dataset.nominal);
                    let tagihanId = this.value; // Mengambil nilai id_tagihan dari checkbox

                    if (this.checked) {
                        total += nominal;
                        selectedTagihan.push(tagihanId);
                    } else {
                        total -= nominal;
                        selectedTagihan = selectedTagihan.filter(id => id !== tagihanId);
                    }

                    totalBayarElement.textContent = 'Rp.' + total.toLocaleString();
                    totalBayarInput.value = total;
                    dumpTagihanInput.value = JSON.stringify(selectedTagihan); // Menyimpan id_tagihan ke dalam dump_tagihan
                });
            });
        });
    </script>
    <!-- snaptoken -->
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            if (!window.snapInstance) {
                window.snapInstance = window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        alert("payment success!");
                        console.log(result);

                        // Redirect ke halaman /bayar/{santri} setelah transaksi berhasil
                        window.location.href = "/bayar/{{ Auth::user()->santri->Id_santri }}";
                    },
                    onPending: function(result) {
                        alert("waiting for your payment!");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("payment failed!");
                        console.log(result);
                    },
                    onClose: function() {
                        alert('you closed the popup without finishing the payment');
                    }
                });
            }
        });
    </script>

</body>
@include('dadmin.style')
@include('dadmin.script')

</html>