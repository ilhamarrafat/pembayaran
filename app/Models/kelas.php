<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'kelas'
    ];
    public function santri()
    {
        return $this->hasMany(Santri::class, 'id_kelas');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}
