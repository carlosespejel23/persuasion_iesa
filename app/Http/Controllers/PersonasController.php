<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarComentario;
use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonasController extends Controller
{
    public function index() {
        $user = User::all();

        if ($user->isEmpty()) {
            $user = null;
        }

        return Inertia::render('Personas/Personas', [
            'user' => $user
        ]);
    }

    //Mostrar personas en la sección principal para observar los perfiles
    public function show() {
        $userId = auth()->user()->getAuthIdentifier();
        $user = DB::table('users')
        ->select(
            'users.id',
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno',
            'users.profile_image',
        )
        ->where('users.id', '!=', $userId)
        ->take(50)
        ->orderBy('users.created_at', 'desc')
        ->get();

        return response()->json($user);
    }

    //Detalles del usuario (perfil)
    public function showProfile($id) {
        $user = User::find($id);

        return Inertia::render('Personas/Profile', [
            'user' => $user
        ]);
    }

    public function showUser($id) {
        $user = DB::table('users')
        ->select(
            'users.id',
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno',
            'users.profile_image',
            'users.email',
            'users.telefono',
            'users.fecha_de_nacimiento',
            'users.created_at', 
        )
        ->where('users.id', '=', $id)
        ->get();

        return response()->json($user);
    }

    public function showPost($id) {
        $post = DB::table('users')
        ->join('posts', function ($join) use ($id) {
            $join->on('posts.usuarios_id', '=', 'users.id')
                ->where('users.id', '=', $id);
        })
        ->select(
            'posts.id',
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno',
            'users.profile_image',
            'posts.contenido',
            'posts.created_at',
            'posts.updated_at'
        )
        ->where('users.id', '=', $id)
        ->orderBy('posts.created_at', 'desc')
        ->get();

        return response()->json($post);
    }

    public function showComment($noticia) {
        $comentarios = DB::table('comentarios')
        ->join('users', function(JoinClause $join) use ($noticia) {
            $join->on('comentarios.usuarios_id', '=', 'users.id')
            ->where('comentarios.posts_id', '=', $noticia);
        })
        ->select(
            'comentarios.id',
            'comentarios.contenido',
            'comentarios.created_at',
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno',
            'users.profile_image'
        )
        ->orderBy('comentarios.created_at', 'desc')
        ->get();

        return response()->json($comentarios);
    }

    public function createComment($noticia)
    {
        $noticias = Noticia::find($noticia);

        return Inertia::render('Personas/Comment', [
            'noticia' => $noticias
        ]);
    }

    public function saveComment(ValidarComentario $request)
    {
        $comentario = Comentario::create($request->validated());

        return Redirect::route('personas'); //aqui se pueden direccionar ventanas modales
    }

    //Seccion deudas
    public function deudas($id) 
    {
        $user = User::find($id);

        return Inertia::render('Personas/Deudas', [
            'user' => $user
        ]);
    }

    public function showDeuda($id) {
        $deuda = DB::table('users')
        ->join('deudores', function ($join) use ($id) {
            $join->on('deudores.usuario_id', '=', 'users.id')
                ->where('users.id', '=', $id);
        })
        ->select(
            'deudores.id',
            'deudores.nombre',
            'deudores.apellidoPaterno',
            'deudores.apellidoMaterno',
            'deudores.monto_a_pagar',
            'deudores.monto_pagado',
            'deudores.created_at'
        )
        ->where('users.id', '=', $id)
        ->orderBy('deudores.created_at', 'desc')
        ->get();

        return response()->json($deuda);
    }

    public function showCommentDeudas($id)
    {
        $user = User::find($id);

        return Inertia::render('Personas/CommentDeuda', [
            'user' => $user
        ]);
    }

    public function showCommentDeuda($id)
    {
        $comentarios = DB::table('comentarios_actualizar_deudas')
            ->join('deudores', function ($join) use ($id) {
                $join->on('comentarios_actualizar_deudas.deudor_id', '=', 'deudores.id')
                    ->where('deudores.id', '=', $id);
            })
            ->select(
                'comentarios_actualizar_deudas.comentario',
                'comentarios_actualizar_deudas.created_at',
                'comentarios_actualizar_deudas.updated_at',
            )
            ->orderBy('comentarios_actualizar_deudas.created_at', 'desc')
            ->get();

        return response()->json($comentarios);
    }
}
