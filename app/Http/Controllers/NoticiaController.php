<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarPost;
use App\Models\Noticia;
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

    public function edit(Noticia $noticia){

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

    //Muestra una sola noticia con sus respectivos elementos y comentarios
    public function show($noticia){
        $noticias = DB::table('posts')
        ->join('users', function($join) use ($noticia) {
            $join->on('posts.usuarios_id', '=', 'users.id')
                ->where('posts.id', '=', $noticia);
                //->andWhere('jobs.summary', 'LIKE', $noticia);
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
        ->get();

        return Inertia::render('Dashboard/Post', [
            'noticias' => $noticias
        ]);
    }

    public function update(Request $request, Noticia $noticia){

    }

    public function destroy(Noticia $noticia){

    }
}
