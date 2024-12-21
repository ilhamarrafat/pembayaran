 <div class="card-body">
     <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
         <table class="table table-bordered">
             <thead class="middle">
                 <tr>
                     <th>Nomor Transaksi</th>
                     <th>Nama Santri</th>
                     <th>Jumlah Pembayaran</th>
                     <th>Metode Pembayaran</th>
                     <th>Tanggal Pembayaran</th>
                     <th>Status Transaksi</th>
                     <th>Deskripsi Transaksi</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 @forelse ($transaksis as $transaksi)
                 <tr>
                     <td>{{ $transaksi->id_transaksi }}</td>
                     <td>{{ $transaksi->santri->nama }}</td>
                     <td>{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                     <td>{{ $transaksi->jenis_pembayaran }}</td>
                     <td>{{ $transaksi->waktu_transaksi }}</td>
                     <td>
                         <span class="badge {{ $transaksi->status_transaksi == 'paid' ? 'bg-success' : 'bg-danger' }}">
                             {{ ucfirst($transaksi->status_transaksi) }}
                         </span>
                     </td>
                     <td>{{ $transaksi->deskripsi }}</td>
                     <td><a class="btn btn-danger" href="{{ route('bayarPdf.pdf', $transaksi->id_transaksi) }}">DETAIL</a>
                     </td>
                 </tr>
                 @empty
                 <tr>
                     <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
                 </tr>
                 @endforelse
             </tbody>
         </table>
     </div>
     <nav aria-label="Page navigation example">
         <div>
             {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
         </div>
     </nav>
 </div>