<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $table = 'Santri';
    protected $primaryKey = 'Id_santri';
    protected $fillable = [
        'Id_santri',
        'user_id',
        'foto',
        'nama',
        'Jenis_kelamin',
        'Tmp_lhr',
        'Tgl_lhr',
        'alamat',
        'Thn_masuk',
        'Thn_keluar',
        'id_kelas',
        'id_tingkat'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(kelas::class, 'id_kelas');
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class, 'id_tingkat');
    }

    public function bayar()
    {
        return $this->hasMany(Bayar::class, 'Id_santri');
    }
    public function transaksi()
    {
        return $this->hasMany(transaksi::class, 'Id_santri');
    }
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'id_kelas', 'id_kelas')
            ->where('id_tigkat', $this->id_tigkat);
    }
}
