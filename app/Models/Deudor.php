<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deudor extends Model
{
    use HasFactory;
    protected $table = 'deudores';
    protected $guarded = [];
    protected $fillable = [
        'usuario_id',
        'nombre',
        'apellidoPaterno',
        'apellidoMaterno',
        'email',
        'telefono',
        'monto_a_pagar',
        'monto_pagado',
    ];
}
