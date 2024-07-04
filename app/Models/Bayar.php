<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'Bayar';
    protected $primaryKey = 'Id_Bayar';

    protected $fillable = [
        'Nominal',
        'Metode',
        'Deskripsi',
        'Waktu',
        'Status',
        'no_transaksi',
        'Id_tagihan'
    ];

    public function tagihan()
    {
        return $this->hasMany(tagihan::class, 'Id_tagihan', 'Id_tagihan');
    }
}
