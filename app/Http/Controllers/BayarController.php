<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\transaksi;
use App\Models\User;
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



class BayarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pagination = 5;
        // Mendapatkan data santri yang sedang login
        $santri = Santri::find(Auth::user()->santri->Id_santri);
        // Ambil data tagihan yang sudah dibayar
        $paidTagihan = Transaksi::with('tagihan') // Eager loading relasi tagihan
            ->where('Id_santri', $santri->Id_santri)
            ->where('status_transaksi', 'paid')
            ->paginate(5);

        $unpaidTagihan = Tagihan::where('id_kelas', $santri->id_kelas) // Pastikan ini merujuk ke id_kelas yang benar
            ->where('id_tingkat', $santri->id_tingkat)
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
            ->paginate(5);

        // Mengembalikan view dengan data yang dibutuhkan
        return view('santri.pembayaran', compact('unpaidTagihan', 'santri', 'paidTagihan'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination);
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

        // Simpan transaksi agar id_transaksi diisi
        $transaksi->save();

        // Menghubungkan transaksi dengan tagihan
        foreach ($Id_tagihan as $id_tagihan) {
            // Pastikan ID tagihan valid sebelum menghubungkan
            if (Tagihan::find($id_tagihan)) {
                $transaksi->tagihan()->attach($id_tagihan);
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
                'quantity' => 1, // Jumlah item (bisa diatur sesuai kebutuhan)
                'name' => $tagihan->nama_tagihan // Nama tagihan yang dibayar
            ];
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.Server_Key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Parameter untuk Midtrans
        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->order_id,
                'gross_amount' => $totalBayar,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->santri->nama,
                'last_name' => '',
                'email' => Auth::user()->email,
                'phone' => '08111222333',
            ),
            'item_details' => $itemDetails
        );

        // Mendapatkan snap token
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Kembalikan tampilan checkout
        return view('santri.cekout', compact('snapToken', 'transaksi'));
        if (!$transaksi->id_transaksi) {
            return back()->withErrors(['transaksi' => 'Transaksi tidak disimpan dengan benar.']);
        }

        // Menghubungkan transaksi dengan tagihan
        foreach ($Id_tagihan as $id_tagihan) {
            $transaksi->tagihan()->attach($id_tagihan);
        }
        $itemDetails = [];
        $tagihanList = Tagihan::whereIn('Id_tagihan', $Id_tagihan)->get();

        foreach ($tagihanList as $tagihan) {
            $itemDetails[] = [
                'id' => $tagihan->Id_tagihan,
                'price' => $tagihan->nominal_tagihan, // Nominal per tagihan
                'quantity' => 1, // Jumlah item (bisa diatur sesuai kebutuhan)
                'name' => $tagihan->nama_tagihan // Nama tagihan yang dibayar
            ];
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.Server_Key');
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // Menggunakan ID transaksi yang baru saja disimpan sebagai order_id
        // $order_id = 'BAYAR-' . $transaksi->id . '-' . time();

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->order_id,
                'gross_amount' => $totalBayar,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->santri->nama,
                'last_name' => '',
                'email' => Auth::user()->email,
                'phone' => '08111222333',
            ),
            'item_details' => $itemDetails
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

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
        $options = new Options();
        $options->set('defaultFont', 'Arial'); // Anda dapat mengubah font default sesuai kebutuhan

        // Inisialisasi dompdf
        $dompdf = new Dompdf($options);

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
