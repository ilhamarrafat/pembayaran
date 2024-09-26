<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    protected $table = 'tagihan';
    protected $primaryKey = 'Id_tagihan';

    protected $fillable = [
        'Id_santri',
        'id_kelas',
        'id_tingkat',
        'nama_tagihan',
        'nominal_tagihan',
        'waktu_tagihan'
    ];
    protected $dates = [
        'waktu_tagihan'
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'Id_santri');
    }
    public function transaksi()
    {
        return $this->belongsToMany(Transaksi::class, 'transaksi_tagihan', 'id_tagihan', 'id_transaksi');
    }
    public function scopeForSantri($query, Santri $santri)
    {
        return $query->where('id_kelas', $santri->id_kelas)
            ->where('id_tingkat', $santri->id_tingkat);
    }
}
