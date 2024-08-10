<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayar extends Model
{
    use HasFactory;
    protected $table = 'Bayar';
    protected $primaryKey = 'Id_Bayar';

    protected $fillable = [
        'nominal_bayar',
        'Metode',
        'Deskripsi',
        'waktu_transaksi',
        'status_transaksi',
        'no_transaksi',
        'Id_tagihan',
        'jenis_transaksi'
    ];
    public function tagihan()
    {
        return $this->belongsToMany(Tagihan::class, 'bayar')
            ->withPivot('status_transaksi', 'waktu_transaksi');
    }
}
