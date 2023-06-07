<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioActualizarDeuda extends Model
{
    use HasFactory;
    protected $table = 'comentarios_actualizar_deudas';
    protected $guarded = [];
    protected $fillable = [
        'comentario',
    ];
}
