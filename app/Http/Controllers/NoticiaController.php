<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarComentario;
use App\Http\Requests\ValidarPost;
use App\Models\Comentario;
use App\Models\Noticia;
use App\Models\Reaction;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NoticiaController extends Controller
{
    public function index(){
        $noticias = Noticia::all();
        $comentarios = Comentario::all();
        $reacciones = Reaction::all();

        return Inertia::render('Dashboard', [
            'noticias' => $noticias,
            'comentarios' => $comentarios,
            'reactions_summary' => $reacciones
        ]);
    }

    public function createPost(){
        return Inertia::render('Dashboard/Create');
    }

    public function savePost(ValidarPost $request){
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
            'users.profile_image',
            'posts.contenido',
            'posts.post_anonimo', 
            'posts.created_at'
        )
        ->orderBy('posts.created_at', 'desc')
        ->take(200)
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
            'comentarios.created_at',
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno',
            'users.profile_image',
        )
        ->orderBy('comentarios.created_at', 'desc')
        ->get();

        return response()->json($comentarios);
    }

    public function createComment($noticia)
    {
        $noticias = Noticia::find($noticia);

        return Inertia::render('Dashboard/Post', [
            'noticia' => $noticias
        ]);
    }

    public function saveComment(ValidarComentario $request)
    {
        $comentario = Comentario::create($request->validated());

        return Redirect::route('dashboard'); //aqui se pueden direccionar ventanas modales
    }

    //Cuenta los comentarios de una noticia
    public function getCount($postId)
    {
        $comentarios = Noticia::findOrFail($postId);

        // Actualiza las estadísticas de los comentarios del post
        $commentsSummary = DB::table('comentarios')
            ->select('posts_id', DB::raw('COUNT(*) as count'))
            ->where('posts_id', '=', $postId)
            ->groupBy('posts_id')
            ->pluck('count', 'posts_id');

        return response()->json(['comments_summary' => $commentsSummary]);
    }
}
