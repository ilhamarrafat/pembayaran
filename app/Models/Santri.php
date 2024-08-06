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
        'Id_tagihan',
        'foto',
        'nama',
        'kelas',
        'Jenis_kelamin',
        'Tmp_lhr',
        'Tgl_lhr',
        'alamat',
        'Thn_masuk',
        'Thn_keluar',
        'tingkat'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'Id_tagihan', 'Id_tagihan');
    }
}
