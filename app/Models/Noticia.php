<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Noticia extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = [];
    protected $fillable = [
        'usuarios_id',
        'contenido',
        'post_anonimo',
        'estado',
    ];
}
