<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentarios';
    protected $guarded = [];
    protected $fillable = [
        'usuarios_id',
        'posts_id',
        'contenido',
        'estado',
    ];
}
