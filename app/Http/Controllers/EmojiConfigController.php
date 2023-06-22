<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarEmojiConfig;
use App\Models\EmojiConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EmojiConfigController extends Controller
{
    /*public function index()
    {
        $user = Auth::user();
        $id = $user->id;

        return Inertia::render('Config/Config', [
            'authUserId' => $id
        ]);
    }*/

    public function edit($id)
    {
        $emoji_config = EmojiConfig::find($id);

        return Inertia::render('Config/Config', [
            'id' => $id,
            'emoji_config' => $emoji_config
        ]);
    }

    public function update(ValidarEmojiConfig $request, $id): RedirectResponse
    {
        $emoji_config = EmojiConfig::find($id);
        
        $emoji_config->fill($request->validated());
        $emoji_config->save();

        return Redirect::route('configuracion.edit', ['id' => $id]);
    }

    /*public function save(ValidarComentarioDeudaPago $request)
    {
        $comentario = ComentarioDeudaPago::create($request->validated());

        return Redirect::route('pagos'); //aqui se pueden direccionar ventanas modales
    }*/
}
