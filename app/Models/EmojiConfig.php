<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmojiConfig extends Model
{
    use HasFactory;
    protected $table = 'emojis_configs';
    protected $guarded = [];
    protected $fillable = [
        'usuario_id',
        'enojo',
        'like',
        'comentar',
        'compartir',
    ];
}
