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
            <td>
                <!-- Tombol print -->
                <button class="icon-button-1">
                    <i class="fa fa-print mb-1" style="font-size:20px;"></i>
                </button>

                <!-- Tombol edit -->
                <a href="{{ route('tagihan.edit', $tag->Id_tagihan) }}" class="icon-button-2">
                    <i class="fas fa-edit mb-1" style="font-size:20px;"></i>
                </a>

                <!-- Tombol hapus -->
                <form action="{{ route('tagihan.destroy', $tag->Id_tagihan) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="icon-button-3 mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
                        <i class="fa fa-trash-o" style="font-size:20px;"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>