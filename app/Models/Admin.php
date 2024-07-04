<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Monolog\Level;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'Admin';
    protected $primaryKey = 'id_admin';
    public function level()
    {
        return $this->belongsTo(level::class, 'Id_level', 'id_level');
    }
}
