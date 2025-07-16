<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /* ───────────────────────
     |  Roles como constantes
     ─────────────────────── */
    public const ROL_ADMIN   = 'admin';
    public const ROL_EDITOR  = 'editor';
    public const ROL_USUARIO = 'usuario';

    /* ───────────────────────
     |  Atributos asignables
     ─────────────────────── */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'activo',
    ];

    /* ───────────────────────
     |  Atributos ocultos
     ─────────────────────── */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* ───────────────────────
     |  Casting de columnas
     ─────────────────────── */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'activo'            => 'boolean',  // ✅ NUEVO
    ];

    /* ───────────────────────
     |  Relaciones
     ─────────────────────── */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    /* ───────────────────────
     |  Helpers de rol (opcional)
     ─────────────────────── */
    public function esAdmin(): bool   { return $this->rol === self::ROL_ADMIN; }
    public function esEditor(): bool  { return $this->rol === self::ROL_EDITOR; }
    public function esUsuario(): bool { return $this->rol === self::ROL_USUARIO; }
}
