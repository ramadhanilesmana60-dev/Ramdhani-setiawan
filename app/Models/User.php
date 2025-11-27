<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nama', 'username', 'password', 'role', 'approved', 'foto'];
    protected $hidden = ['password'];

    public function artikels()
    {
        return $this->hasMany(Artikel::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }
}