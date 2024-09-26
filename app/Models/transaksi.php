<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi'; // Jika kolom kunci primer bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'Id_santri',
        'Id_tagihan',
        'total_bayar',
        'deskripsi',
        'jenis_pembayaran',
        'status_transaksi',
        'waktu_transaksi'
    ];
    protected $dates = [
        'waktu_tagihan'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'Id_santri');
    }

    public function tagihan()
    {
        return $this->belongsToMany(Tagihan::class, 'transaksi_tagihan', 'id_transaksi', 'id_tagihan');
    }
}
