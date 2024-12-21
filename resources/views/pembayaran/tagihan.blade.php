 <div class="card-body">
     <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
         <table class="table table-bordered">
             <thead class="middle">
                 <tr>
                     <th>No</th>
                     <th>Nama Tagihan</th>
                     <th>Nominal Tagihan</th>
                     <th>Waktu dibuat</th>
                     <th>Batas Tempo</th>
                     <th>Kelas</th>
                     <th>Tingkat</th>
                     <th>Periode</th>
                     <th>Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 @php
                 $no = 1;
                 @endphp
                 @foreach($tagihans as $tag)
                 <tr>
                     <td>{{ $no++ }}</td>
                     <td>{{ $tag->nama_tagihan }}</td>
                     <td>Rp. {{ number_format($tag->nominal_tagihan, 0, ',', '.') }}</td>
                     <td>{{ $tag->created_at }}</td>
                     <td>{{ $tag->waktu_tagihan }}</td>
                     <td>{{ $tag->id_kelas ?? '-' }}</td>
                     <td>{{ $tag->id_tingkat ?? '-' }}</td>
                     <td>{{ $tag->periode_tagihan == 'bulanan' ? 'Setiap Bulan' : 'Sekali' }}</td> <!-- Informasi Periode -->
                     <td>
                         <!-- Tombol print -->
                         <button class="icon-button-1" onclick="return confirmPrint(event);">
                             <i class="fa fa-print mb-1" style="font-size:20px;"></i>
                         </button>

                         <!-- Tombol edit -->
                         <a href="{{ route('tagihan.edit', $tag->Id_tagihan) }}" class="icon-button-2" onclick="return confirmEdit(event);">
                             <i class="fas fa-edit mb-1" style="font-size:20px;"></i>
                         </a>

                         <!-- Tombol hapus -->
                         <form action="{{ route('tagihan.destroy', $tag->Id_tagihan) }}" method="post" style="display:inline;">
                             @csrf
                             @method('DELETE')
                             <button type="submit" class="icon-button-3 mb-1" onclick="return confirmDelete(event);">
                                 <i class="fa fa-trash-o" style="font-size:20px;"></i>
                             </button>
                         </form>
                     </td>
                 </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
     <nav aria-label="Page navigation example">
         <div>
             {{ $tagihans->onEachSide(1)->links('pagination::bootstrap-5', ['size' => 'sm']) }}
         </div>
     </nav>
 </div>