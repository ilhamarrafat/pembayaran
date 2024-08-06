<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul',       // Misalnya atribut lain
        'isi',     // Misalnya atribut lain
        'gambar',      // Tambahkan atribut gambar di sini
    ];
}
