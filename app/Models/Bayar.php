<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayar extends Model
{
    use HasFactory;
    protected $table = 'bayar';
    protected $primaryKey = 'Id_Bayar';

    protected $fillable = [
        'Id_bayar',
        'Metode',
        'Deskripsi',
        'waktu_transaksi',
        'jenis_transaksi',
        'status_transaksi',
        'Id_santri',
        'total_bayar',
        'Id_tagihan',
        'total_tagihan'
    ];
    // Model Bayar

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }
}
