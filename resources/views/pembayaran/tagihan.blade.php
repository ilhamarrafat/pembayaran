<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Tagihan</th>
            <th>Nominal Tagihan</th>
            <th>Batas Waktu</th>
            <th>Kelas</th>
            <th>Tingkat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        @endphp
        @foreach($tagihan as $tag)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $tag->nama_tagihan }}</td>
            <td>Rp. {{ number_format($tag->nominal_tagihan, 0, ',', '.') }}</td>
            <td>{{ $tag->waktu_tagihan }}</td>
            <td>{{ $tag->id_kelas }}</td>
            <td>{{ $tag->id_tingkat }}</td>
            <td>Lihat Detail</td>
        </tr>
        @endforeach
    </tbody>
</table>