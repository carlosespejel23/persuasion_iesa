<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioDeudaPago extends Model
{
    use HasFactory;
    protected $table = 'comentarios_deudas_pagos';
    protected $guarded = [];
    protected $fillable = [
        'usuario_id',
        'deudor_id',
        'comentario',
    ];
}
