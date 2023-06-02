<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Qirolab\Laravel\Reactions\Models\Reaction;

class PostVoteController extends Controller
{
    public function store(Request $request, Noticia $noticia, $postId){
        $type = $request->get('type');
        $userId = auth()->user()->getAuthIdentifier();

        //Revisa si ya existe un voto para este post por este usuario
        $postVote = Reaction::firstOrNew(['user_id' => $userId, 'posts_id' => $postId]);

        //Si no existe, crear voto
        if(!$postVote->exists){
            $postVote->type = $type;
            $postVote->save();
        } else{
            //Si existe, actualizar el voto
            Reaction::where(['user_id' => $userId, 'posts_id' => $postId])->update(['type' => $type]);
        }

        /*$postVote = new PostVote;
        $postVote->usuarios_id = $userId;
        $postVote->posts_id = $postId;
        $postVote->vote = $vote;
        $postVote->save();*/

        //$noticia->toggleReaction($request->reaction);

        return response()->json($postVote);
    }
}
