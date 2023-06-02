<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Qirolab\Laravel\Reactions\Traits\Reactable;
use Qirolab\Laravel\Reactions\Contracts\ReactableInterface;

class Noticia extends Model implements ReactableInterface
{
    use HasFactory, Reactable;
    protected $table = 'posts';
    protected $guarded = [];
    protected $fillable = [
        'usuarios_id',
        'contenido',
        'post_anonimo',
        'estado',
    ];
}
