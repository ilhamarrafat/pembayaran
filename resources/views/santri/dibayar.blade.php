<div class="card">
    <div class="card-header border-success">
        <h4>
            <b>
                TAGIHAN YANG SUDAH DIBAYAR
            </b>
        </h4>
        <form class="row g-4" action="{{ route('pembayaran.index') }}" method="GET">
            <div class="col-auto">
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary"></a>
            </div>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel Tagihan Sudah Dibayar -->

            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-3" id="paid-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tagihan</th>
                            <th>Nominal</th>
                            <th>Waktu</th>
                            <th>Cetak</th>
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
                            <td><a class="btn btn-danger" href="{{ route('download.pdf', $transaksi->id_transaksi) }}">Cetak PDF</a></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">Belum ada tagihan yang dibayar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <div>
                    {{ $paidTagihan->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
                </div>
            </nav>
        </div>
    </div>
</div>