<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tingkat extends Model
{
    use HasFactory;
    protected $table = 'tingkat';
    protected $primaryKey = 'id_tingkat';
    protected $fillable = [
        'tingkat'
    ];
    public function santri()
    {
        return $this->hasMany(Santri::class, 'id_tingkat');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}
