<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPostRequest;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NoticiaUserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Profile/Noticias', [
            'user' => $request->user(),
        ]);
    }

    //Mostrar todas las noticias del usuario autenticado
    public function showPost() {
        $id = auth()->user()->getAuthIdentifier();
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
            'posts.created_at'
        )
        ->orderBy('posts.created_at', 'desc')
        ->get();

        return response()->json($post);
    }

    //Editar la noticia del usuario autenticado
    public function editPost($id) {
        $userId = auth()->user()->getAuthIdentifier();
        $noticiaUsers = Noticia::where('usuarios_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($noticiaUsers->isNotEmpty()) {
            $noticia = $noticiaUsers->first();
            return Inertia::render('Profile/EditarNoticia', [
                'noticia' => $noticia
            ]);
        } else {
            return Redirect::route('noticias');
        }
    }

    public function updatePost(UpdateUserPostRequest $request, $id) {
        $userId = auth()->user()->getAuthIdentifier();
        $noticiaUsers = Noticia::where('usuarios_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($noticiaUsers->isNotEmpty()) {
            $noticia = $noticiaUsers->first();
        
            $noticia->fill($request->validated());
            $noticia->save();

            return Redirect::route('noticias');
        } else {
            return Redirect::route('noticias');
        }
    }

    //Eliminar noticia del usuario
    public function deletePost($id) {
        $userId = auth()->user()->getAuthIdentifier();
        $noticiaUsers = Noticia::where('usuarios_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($noticiaUsers->isNotEmpty()) {
            $noticia = $noticiaUsers->first();
            $noticia->delete();

            return Redirect::route('noticias');
        } else {
            return Redirect::route('noticias');
        }
    }
}
