<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\transaksi;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Config;
use PDF;



class BayarController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $pagination = 5;

        // Mendapatkan data santri yang sedang login
        $santri = Santri::with(['kelas', 'tingkat'])->find(Auth::user()->santri->Id_santri);

        // Cek apakah santri ditemukan dan statusnya aktif
        if (!$santri || $santri->status !== 'aktif') {
            // Jika santri tidak aktif, set tagihan menjadi 0
            return view('santri.pembayaran', [
                'unpaidTagihan' => collect(), // Tidak ada tagihan
                'santri' => $santri,
                'paidTagihan' => collect(),  // Tidak ada tagihan yang sudah dibayar
                'isPaginated' => false // Menandakan tidak ada pagination
            ]);
        }

        // Ambil bulan dan tahun masuk santri
        $bulanMasuk = Carbon::createFromFormat('Y-m-d', $santri->Thn_masuk)->month;
        $tahunMasuk = Carbon::createFromFormat('Y-m-d', $santri->Thn_masuk)->year;

        // Tagihan unpaid (belum dibayar) untuk santri berdasarkan kelas, tingkat, dan bulan masuk
        $unpaidTagihan = Tagihan::where('id_kelas', $santri->id_kelas)
            ->where('id_tingkat', $santri->id_tingkat)
            ->whereYear('waktu_tagihan', '>=', $tahunMasuk)
            ->where(function ($query) use ($bulanMasuk, $tahunMasuk) {
                $query->whereYear('waktu_tagihan', '>', $tahunMasuk)
                    ->orWhere(function ($subQuery) use ($bulanMasuk, $tahunMasuk) {
                        $subQuery->whereYear('waktu_tagihan', $tahunMasuk)
                            ->whereMonth('waktu_tagihan', '>=', $bulanMasuk);
                    });
            })
            ->whereNotIn('Id_tagihan', function ($query) use ($santri) {
                $query->select('id_tagihan')
                    ->from('transaksi_tagihan')
                    ->whereIn('id_transaksi', function ($subQuery) use ($santri) {
                        $subQuery->select('id_transaksi')
                            ->from('transaksi')
                            ->where('Id_santri', $santri->Id_santri)
                            ->where('status_transaksi', 'paid');
                    });
            })
            ->orderBy('waktu_tagihan', 'desc')
            ->paginate($pagination); // Pagination untuk tagihan yang belum dibayar

        // Tagihan paid (sudah dibayar)
        $paidTagihan = Transaksi::with('tagihan')
            ->where('Id_santri', $santri->Id_santri)
            ->where('status_transaksi', 'paid')
            ->paginate($pagination); // Pagination untuk tagihan yang sudah dibayar

        // Mengembalikan view dengan data yang dibutuhkan
        return view('santri.pembayaran', compact('unpaidTagihan', 'santri', 'paidTagihan'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination)
            ->with('isPaginated', true); // Menandakan bahwa data ini dipaginasi
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaksi = transaksi::all()->map(function ($transaksi) {
            $transaksi->waktu_transaksi = new \Carbon\Carbon($transaksi->waktu_transaksi);
            return $transaksi;
        });
        return view('santri.cekout', compact('snapToken', 'transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'total_bayar' => 'required|numeric',
            'dump_tagihan' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        $totalBayar = $request->input('total_bayar');
        $Id_tagihan = json_decode($request->input('dump_tagihan'), true);
        $idSantri = Auth::user()->santri->Id_santri;

        // Cek jika tagihan valid
        if (empty($Id_tagihan) || !is_array($Id_tagihan)) {
            return back()->withErrors(['dump_tagihan' => 'Tagihan tidak valid atau tidak ditemukan']);
        }

        // Membuat transaksi baru
        $transaksi = new Transaksi();
        $transaksi->jenis_pembayaran = "Pembayaran Tagihan";
        $transaksi->Id_santri = $idSantri;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->total_bayar = $totalBayar;
        $transaksi->status_transaksi = 'unpaid';
        $transaksi->waktu_transaksi = Carbon::now();
        $transaksi->order_id = 'BAYAR-' . uniqid(); // Membuat order_id unik

        // Simpan transaksi
        $transaksi->save();

        // Menghubungkan transaksi dengan tagihan menggunakan pivot table
        foreach ($Id_tagihan as $id_tagihan) {
            $tagihan = Tagihan::find($id_tagihan);
            if ($tagihan) {
                $transaksi->tagihan()->attach($tagihan);
            } else {
                return back()->withErrors(['tagihan' => 'Tagihan tidak ditemukan: ' . $id_tagihan]);
            }
        }

        // Menyiapkan detail item untuk Midtrans
        $itemDetails = [];
        $tagihanList = Tagihan::whereIn('Id_tagihan', $Id_tagihan)->get();

        foreach ($tagihanList as $tagihan) {
            $itemDetails[] = [
                'id' => $tagihan->Id_tagihan,
                'price' => $tagihan->nominal_tagihan, // Nominal per tagihan
                'quantity' => 1, // Jumlah item 
                'name' => $tagihan->nama_tagihan // Nama tagihan yang dibayar
            ];
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.Server_Key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->order_id,
                'gross_amount' => $totalBayar,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->santri->nama,
                'last_name' => '',
                'email' => Auth::user()->email,
                'phone' => Auth::user()->santri->telepon,
            ],
            'item_details' => $itemDetails
        ];

        // Mendapatkan snap token dari Midtrans
        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->withErrors(['midtrans' => 'Gagal mendapatkan token pembayaran.']);
        }

        // Kembalikan tampilan checkout dengan snap token dan transaksi
        return view('santri.cekout', compact('snapToken', 'transaksi'));
    }





    public function callback(Request $request)
    {
        $serverKey = config('midtrans.Server_Key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                // Cari transaksi berdasarkan order_id yang dikirim dari Midtrans
                $transaksi = transaksi::where('order_id', $request->order_id)->first();

                // Jika transaksi ditemukan, ubah statusnya menjadi 'paid'
                if ($transaksi) {
                    $transaksi->status_transaksi = 'paid';
                    $transaksi->waktu_transaksi = now();
                    $transaksi->save();
                }
            }
        }
    }
    public function downloadPdf($id)
    {
        // Ambil data transaksi dan relasi tagihan
        $transaksi = Transaksi::with('tagihan')->findOrFail($id);

        // Siapkan data untuk view PDF
        $data = [
            'transaksi' => $transaksi,
            'santri' => $transaksi->santri, // relasi ke model Santri
            'tagihan' => $transaksi->tagihan,
        ];

        // Render HTML dari view untuk PDF
        $html = view('pembayaran.cetak', $data)->render();

        // Setel opsi dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true); // Aktifkan remote resource

        // Inisialisasi dompdf dengan opsi
        $dompdf = new \Dompdf\Dompdf($options);

        // Load HTML ke dalam dompdf dan generate PDF
        $dompdf->loadHtml($html);

        // (Optional) Set ukuran kertas dan orientasi
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output file PDF ke browser untuk diunduh
        return $dompdf->stream('tagihan_' . $transaksi->id_transaksi . '.pdf', ['Attachment' => true]); // 'Attachment' => true untuk download
    }
}
