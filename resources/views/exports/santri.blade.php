<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Tempat Lhr</th>
            <th>Tgl Lahir</th>
            <th>Tahun Masuk</th>
            <th>Tahun Keluar</th>
            <th>Kelas</th>
            <th>Tingkat</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0; ?>
        @foreach($santri as $item)
        <tr>
            <td>{{ ++$i }}</td> <!-- Nomor Urut -->
            <td>
                @if ($item->foto)
                <img class="mb-1" src="{{ url('storage/' . $item->foto) }}" style="width: 50px;">
                @endif
            </td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->Jenis_kelamin }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->Tmp_lhr }}</td>
            <td>{{ $item->Tgl_lhr }}</td>
            <td>{{ $item->Thn_masuk }}</td>
            <td>{{ $item->Thn_keluar }}</td>
            <td>{{ $item->kelas->kelas }}</td>
            <td>{{ $item->tingkat->tingkat }}</td>
        </tr>
        @endforeach
    </tbody>
</table>