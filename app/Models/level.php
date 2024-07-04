<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;
    protected $table = 'level';
    protected $primaryKey = 'id_level';

    public function admins()
    {
        return $this->hasMany(Admin::class, 'Id_level', 'id_level');
    }

    public function santris()
    {
        return $this->hasMany(Santri::class, 'Id_level', 'id_level');
    }
}
