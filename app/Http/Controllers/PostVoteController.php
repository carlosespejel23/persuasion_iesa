<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostVoteController extends Controller
{
    public function store(Request $request, $postId)
    {
        $post = Noticia::findOrFail($postId);
        $user = auth()->user(); // Obtén el usuario autenticado

        // Guarda o actualiza la reacción del usuario para este post
        $post->reactions()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => $request->input('reaction')]
        );

        // Actualiza las estadísticas de reacciones del post
        $reactionsSummary = $post->reactions()
            ->select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type');

        return response()->json(['reactions_summary' => $reactionsSummary]);
    }

    public function getCount($postId)
    {
        $post = Noticia::findOrFail($postId);

        // Actualiza las estadísticas de reacciones del post
        $reactionsSummary = $post->reactions()
            ->select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type');

        return response()->json(['reactions_summary' => $reactionsSummary]);
    }
}
