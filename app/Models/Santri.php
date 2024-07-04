<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $table = 'Santri';
    protected $primaryKey = 'Id_santri';

    public function level()
    {
        return $this->belongsTo(level::class, 'Id_level', 'id_level');
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'Id_tagihan', 'Id_tagihan');
    }
}
