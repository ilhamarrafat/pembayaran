<div class="card mb-3">
    <div class="card-header border-success">
        <h2>
            <b>TAGIHAN SANTRI</b>
        </h2>
        <form class="row g-3" action="{{ route('pembayaran.index') }}" method="GET">
            <div class="col-auto">
                <input class="form-control" type="text" name="search" placeholder="Search" aria-label="default input example" value="{{ request('search') }}">
            </div>
            <button class="btn btn-primary" type="submit">Cari</button>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel Tagihan Belum Dibayar -->
            <h4>
                <b>TAGIHAN YANG BELUM DIBAYAR</b>
            </h4>
            <div class="card-header text-center">
                <h3 class="mb-0">Tagihan untuk: <strong>{{ Auth::user()->name }}</strong></h3>
            </div>

            <table class="table table-striped table-bordered" id="unpaid-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tagihan</th>
                        <th>Tanggal dibuat</th>
                        <th>Akhir Pembayaran</th>
                        <th>Nominal</th>
                        <th>Pilih</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unpaidTagihan as $item)
                    <tr>
                        <td>{{ ($unpaidTagihan->currentPage() - 1) * $unpaidTagihan->perPage() + $loop->iteration }}</td>
                        <td>{{ $item->nama_tagihan }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->waktu_tagihan }}</td>
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
            <h6><b>Total Semua Tagihan:</b> <span id="total_semua_tagihan">Rp.{{ number_format($unpaidTagihan->sum('nominal_tagihan'), 0, ',', '.') }}</span></h6>
            <h6> <b>Total Tagihan yang Dipilih:</b> <span id="total_tagihan_pilih">Rp.0</span></h6>
            <h6>
                <b>Total Bayar:</b><span id="total_bayar">Rp.0</span>
            </h6>
            <form method="POST" action="{{ route('cekout') }}" class="mt-4 mb-3">
                @csrf
                <input type="hidden" name="total_bayar" id="total_bayar_input" value="0">
                <input type="hidden" name="dump_tagihan" id="dump_tagihan">
                <input type="hidden" name="deskripsi" id="dump_nama_tagihan">
                <input type="hidden" name="Id_santri" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-primary btn-block mt-4">Bayar Sekarang</button>
            </form>
            @if($isPaginated)
            <nav aria-label="Page navigation example">
                <div>
                    {{ $unpaidTagihan->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
                </div>
            </nav>
            @else
            <p>No tagihan available.</p> <!-- Jika tidak ada tagihan, tampilkan pesan ini -->
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.checkbox-tagihan');
            const totalTagihanPilih = document.getElementById('total_tagihan_pilih');
            const totalBayar = document.getElementById('total_bayar');
            const totalBayarInput = document.getElementById('total_bayar_input');
            const dumpTagihan = document.getElementById('dump_tagihan');
            const dumpNamaTagihan = document.getElementById('dump_nama_tagihan');

            let selectedTagihan = [];
            let selectedNamaTagihan = [];

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const nominal = parseInt(this.getAttribute('data-nominal'));
                    const namaTagihan = this.getAttribute('data-namatagihan');
                    const idTagihan = this.value;

                    if (this.checked) {
                        selectedTagihan.push(idTagihan);
                        selectedNamaTagihan.push(namaTagihan);
                    } else {
                        selectedTagihan = selectedTagihan.filter(id => id !== idTagihan);
                        selectedNamaTagihan = selectedNamaTagihan.filter(nama => nama !== namaTagihan);
                    }

                    // Update total bayar
                    const totalNominal = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .reduce((sum, checkbox) => sum + parseInt(checkbox.getAttribute('data-nominal')), 0);

                    totalTagihanPilih.innerText = `Rp.${totalNominal.toLocaleString('id-ID')}`;
                    totalBayar.innerText = `Rp.${totalNominal.toLocaleString('id-ID')}`;
                    totalBayarInput.value = totalNominal;

                    // Update hidden inputs
                    dumpTagihan.value = selectedTagihan.join(',');
                    dumpNamaTagihan.value = selectedNamaTagihan.join(', ');
                });
            });
        });
    </script>
</div>