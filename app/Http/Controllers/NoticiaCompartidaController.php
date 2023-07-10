<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NoticiaCompartidaController extends Controller
{
    public function index($slug) {

        $urlSlug = Noticia::where('slug', $slug)->get();

        if ($urlSlug->isNotEmpty()) {
            $slug = $urlSlug->first();
            return Inertia::render('NoticiaCompartida/NoticiaCompartida', [
                'slug' => $slug
            ]);
        } else {
            return Redirect::route('home');
        }
    }

    public function showPost($slug){
        $urlSlug = Noticia::where('slug', $slug)->get();

        if ($urlSlug->isNotEmpty()) {
            $noticias = DB::table('posts')
            ->join('users', function($join) use ($slug) {
                $join->on('posts.usuarios_id', '=', 'users.id')
                ->where('posts.slug', '=', $slug);
            })
            ->select(
                'posts.id',
                'posts.slug', 
                'users.nombre', 
                'users.apellidoPaterno', 
                'users.apellidoMaterno', 
                'users.profile_image',
                'posts.contenido', 
                'posts.post_anonimo',
                'posts.created_at'
            )
            ->get();

            return response()->json($noticias);
        } else {
            return response()->json(null);
        }
    }

    public function showComment($slug) {
        $urlSlug = Noticia::where('slug', $slug)->get();

        if ($urlSlug->isNotEmpty()) {
            $comentarios = DB::table('comentarios')
            ->join('users', 'comentarios.usuarios_id', '=', 'users.id')
            ->join('posts', function($join) use ($slug) {
                $join->on('posts.id', '=', 'comentarios.posts_id')
                    ->where('posts.slug', '=', $slug);
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
        } else {
            return response()->json(null);
        }
    }
}
