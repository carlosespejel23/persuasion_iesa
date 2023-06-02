<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarComentario;
use App\Http\Requests\ValidarPost;
use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NoticiaController extends Controller
{
    public function index(){
        $noticias = Noticia::all();

        return Inertia::render('Dashboard', [
            'noticias' => $noticias
        ]);
    }
    public function create(){
        return Inertia::render('Dashboard/Create');
    }

    public function save(ValidarPost $request){
        $noticia = Noticia::create($request->validated());

        return Redirect::route('dashboard');
    }

    //Muestra todas las noticias en el panel principal
    public function showAll(){
        $noticias = DB::table('posts')
        ->join('users', function($join) {
            $join->on('posts.usuarios_id', '=', 'users.id');
        })
        ->select(
            'posts.id', 
            'posts.usuarios_id', 
            'posts.slug', 
            'users.nombre', 
            'users.apellidoPaterno', 
            'users.apellidoMaterno', 
            'posts.contenido', 
            'posts.estado', 
            'posts.post_anonimo', 
            'posts.created_at', 
            'posts.updated_at'
        )
        ->orderBy('posts.created_at', 'desc')
        ->get();

        return response()->json($noticias);
    }

    //Muestra comentarios de una sola noticia
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
    
    public function saveComment(ValidarComentario $request, $noticia){
        $comentario = Comentario::create($request->validated());

        return Redirect::route('dashboard.show', ['noticia' => $request->posts_id]);
    }
}
