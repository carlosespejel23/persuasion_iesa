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
    protected $signature = 'persuasion:install_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para iniciar con una cuenta de usuario ficticio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if(!$this->verificar()){
            $this->info('Usuario creado correctamente');

            $rol = $this->crearRolUsuario();
            $usuario = $this->crearUsuario();

            //Relacionarlo
            $usuario->roles()->attach($rol);
        }else{
            $this->error('Ya existe un usuario');
        }
    }

    private function verificar(){
        return Rol::find(1);
    }

    private function crearRolUsuario(){
        $rol = 'Usuario';
        return Rol::create([
            'nombre' => $rol,
            'slug' => Str::slug($rol, '_')
        ]);
    }

    private function crearUsuario(){
        return User::create([
            'nombre' => 'Nombre Usuario',
            'apellidoPaterno' => 'Apellido Paterno Usuario',
            'apellidoMaterno' => 'Apellido Materno Usuario',
            'telefono' => '0000000000',
            'fecha_de_nacimiento' => '2021-01-01',
            'acepto_contrato' => 1,
            'email' => 'example@email.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
