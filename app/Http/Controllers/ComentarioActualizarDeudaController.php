<?php

namespace App\Http\Controllers;

use App\Models\ComentarioActualizarDeuda;
use App\Models\Deudor;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ComentarioActualizarDeudaController extends Controller
{
    public function index(){
        $deudor = Deudor::all();
        $comentarios = ComentarioActualizarDeuda::all();

        if ($deudor->isEmpty() && $comentarios->isEmpty()) {
            $deudor = null;
            $comentarios = null;
        }

        return Inertia::render('Deudas/Deudas', [
            'deudor' => $deudor,
            'comentarios' => $comentarios
        ]);
    }

    public function handle()
    {
        $userId = auth()->user()->getAuthIdentifier();

        $comentario_AD = $this->create();
        $deudor = $this->show();
        $usuario = User::find($userId);

        //Relacionarlo
        $usuario->deudores()->attach($deudor);
        $usuario->comentarios_actualizar_deudas()->attach($comentario_AD);
    }

    public function show(){
        $userId = auth()->user()->getAuthIdentifier();
        $deudor = DB::table('deudores')
        ->join('users', function(JoinClause $join) use ($userId) {
            $join->on('deudores.usuario_id', '=', 'users.id')
            ->where('users.id', '=', $userId);
        })
        ->select(
            'deudores.id',
            'deudores.usuario_id',
            'deudores.nombre',
            'deudores.apellidoPaterno',
            'deudores.apellidoMaterno',
            'deudores.email',
            'deudores.telefono',
            'deudores.created_at',
            'deudores.updated_at',
        )
        ->orderBy('deudores.created_at', 'desc')
        ->get();

        return response()->json($deudor);
    }

    public function showComment($noticia){
        $comentarios = DB::table('comentarios')
        ->join('users', function(JoinClause $join) use ($noticia) {
            $join->on('comentarios.usuarios_id', '=', 'users.id')
            ->where('comentarios.posts_id', '=', $noticia);
        })
        ->select(
            'comentarios.id',
            'comentarios.usuarios_id',
            'comentarios.posts_id',
            'comentarios.contenido',
            'comentarios.estado',
            'comentarios.created_at',
            'comentarios.updated_at',
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno'
        )
        ->orderBy('comentarios.created_at', 'desc')
        ->get();

        return response()->json($comentarios);
    }
    
    /*public function saveComment(ValidarComentario $request, $noticia){
        $comentario = Comentario::create($request->validated());

        return Redirect::route('dashboard.show', ['noticia' => $request->posts_id]);
    }*/
}
