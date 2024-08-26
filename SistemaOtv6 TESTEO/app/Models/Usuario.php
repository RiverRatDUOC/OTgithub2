<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuario';

    protected $primaryKey = 'id';

    public $incrementing = false; // Si id no es auto-incremental, cambiar a true si es auto-incremental

    protected $fillable = [
        'nombre_usuario',
        'password_usuario',
        'rol_usuario',
        'email_usuario',
        'email_verified_at',
    ];

    protected $hidden = [
        'password_usuario',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'email_verified_at'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
