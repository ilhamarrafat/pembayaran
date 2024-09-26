  <table class="table  table-bordered">
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
      <tbody class="table-group-divider">
          @foreach ($transaksis as $transaksi)
          <tr>
              <td>{{ $transaksi->id_transaksi }}</td>
              <td>{{ $transaksi->santri->nama }}</td> <!-- Ambil nama santri dari relasi -->
              <td>{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td> <!-- Format jumlah pembayaran -->
              <td>{{ $transaksi->jenis_pembayaran }}</td>
              <td>{{ $transaksi->waktu_transaksi}}</td>
              <td>{{ $transaksi->status_transaksi }}</td>
              <td>{{ $transaksi->deskripsi }}</td>
              <td>
                  Aksi
              </td>
          </tr>
          @endforeach
      </tbody>
  </table>