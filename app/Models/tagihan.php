<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagihan extends Model
{
    use HasFactory;
    protected $table = 'tagihan';
    protected $primaryKey = 'Id_tagihan';

    public function santri()
    {
        return $this->hasOne(Santri::class, 'Id_tagihan', 'Id_tagihan');
    }
}
