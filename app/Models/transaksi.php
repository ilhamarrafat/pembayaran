<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi'; // Tentukan kolom kunci primer
    public $incrementing = false; // Jika kolom kunci primer bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'id_transaksi',
        'Id_santri',
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

    public function bayar()
    {
        return $this->hasMany(Bayar::class);
    }
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'Id_tagihan', 'Id_tagihan');
    }
}
