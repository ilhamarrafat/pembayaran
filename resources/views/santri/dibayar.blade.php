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
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paidTagihan as $index => $transaksi)
                        <tr>
                            <td>{{ $paidTagihan->firstItem() + $index }}</td>
                            <td>
                                @foreach ($transaksi->tagihan as $tagihan)
                                {{ $tagihan->nama_tagihan }}<br>
                                @endforeach
                            </td>

                            <td>{{ number_format($transaksi->total_bayar, 2) }}</td>
                            <td>{{ $transaksi->waktu_transaksi }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">Tidak ada tagihan yang dibayar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer clearfix">
        <a href="javascript:void(0)" class="btn btn-sm btn-success float-right">View All Orders</a>
    </div>
</div>
{{ $paidTagihan->links() }}