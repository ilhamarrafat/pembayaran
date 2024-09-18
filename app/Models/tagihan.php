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

    public function bayar()
    {
        return $this->hasMany(Bayar::class);
    }
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
