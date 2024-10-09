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
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'foto',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }
}
