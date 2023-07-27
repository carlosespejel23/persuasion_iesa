<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class NoticiaUserController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Profile/Noticias', [
            'user' => $request->user(),
        ]);
    }

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
}
