<?php

namespace App\Console\Commands;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:frase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando de prueba';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('
            “A partir de hoy voy a construir mi mejor versión, 
            cuidando mi esencia, mi cuerpo y salud mental. 
            Estoy consciente que el caminar es difícil, 
            pero eso no me aleja de mi propósito.
            Con esfuerzo y disciplina regresaré a él. 
            Porque tengo una misión de vida.”
        ');
    }
}
