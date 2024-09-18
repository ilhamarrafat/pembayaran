<?php

namespace App\Http\Controllers;

use App\Models\Bayar;
use App\Models\Santri;
use App\Models\tagihan;
use App\Models\transaksi;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $santri = Auth::user()->santri;
        // Ambil semua ID tagihan yang sudah dibayar oleh santri
        $paidTagihanIds = transaksi::where('Id_santri', $santri->Id_santri)
            ->where('status_transaksi', 'paid')
            ->pluck('Id_tagihan');

        // Mendapatkan tagihan yang sesuai dengan kelas dan tingkat santri, dan belum dibayar
        $tagihan = tagihan::where('id_kelas', $santri->id_kelas)
            ->where('id_tingkat', $santri->id_tingkat)
            ->whereNotIn('id', $paidTagihanIds) // Filter tagihan yang belum dibayar
            ->orderBy('created_at', 'desc')
            ->paginate($pagination);

        return view('santri.pembayaran', compact('tagihan', 'santri'))
            ->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $totalBayar = $request->input('total_bayar');
        $Id_tagihan = json_decode($request->input('dump_tagihan'), true);
        $idSantri = Auth::user()->santri->Id_santri;
        //     if (!empty($Id_tagihan) && is_array($Id_tagihan)) {

        $Id_tagihan = (int) $Id_tagihan[0];
        // Membuat transaksi baru
        $transaksi = new transaksi();
        $transaksi->jenis_pembayaran = "Pembayaran Tagihan";
        $transaksi->Id_santri = $idSantri;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->total_bayar = $totalBayar;
        $transaksi->status_transaksi = 'unpaid';
        $transaksi->waktu_transaksi = Carbon::now();
        // $transaksi->Id_tagihan = $Id_tagihan;
        $transaksi->save();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.Server_Key');
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        // Menggunakan ID transaksi yang baru saja disimpan sebagai order_id
        // $transaksi = 'BAYAR-' .

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaksi->id,
                'gross_amount' => $totalBayar,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->santri->nama,
                'last_name' => '',
                'email' => Auth::user()->email,
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('santri.cekout', compact('snapToken', 'transaksi'));
    }




    public function callback(Request $request)
    {
        $serverKey = config('midtrans.Server_Key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $transaksi = transaksi::find($request->order_id);
                // $transaksi->update([
                //     'status_transaksi' => 'paid',
                //     'waktu_transaksi' => now()
                // ]);
                $transaksi->status_transaksi = 'paid';
                $transaksi->save();
            }
        }
    }
}
