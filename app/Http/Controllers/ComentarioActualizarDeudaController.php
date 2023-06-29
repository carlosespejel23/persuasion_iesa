<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarComentarioActualizarDeuda;
use App\Models\ComentarioActualizarDeuda;
use App\Models\Deudor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ComentarioActualizarDeudaController extends Controller
{
    public function index()
    {
        $deudor = Deudor::all();
        $comentarios = ComentarioActualizarDeuda::all();

        if ($deudor->isEmpty() && $comentarios->isEmpty()) {
            $deudor = null;
            $comentarios = null;
        }

        return Inertia::render('Deudas/Deudas', [
            'deudor' => $deudor,
            'comentarios' => $comentarios
        ]);
    }

    public function create($id)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $deudor = $deudorUsers->first();
            return Inertia::render('Deudas/CreateComment', [
                'deudor' => $deudor
            ]);
        } else {
            return Redirect::route('deudas');
        }
    }

    public function showComment($id)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $comentarios = DB::table('comentarios_actualizar_deudas')
            ->join('deudores', function ($join) use ($id) {
                $join->on('comentarios_actualizar_deudas.deudor_id', '=', 'deudores.id')
                    ->where('deudores.id', '=', $id);
            })
            ->join('users', function ($join) use ($userId) {
                $join->on('comentarios_actualizar_deudas.usuario_id', '=', 'users.id')
                    ->where('users.id', '=', $userId);
            })
            ->select(
                'comentarios_actualizar_deudas.comentario',
                'comentarios_actualizar_deudas.created_at',
                'comentarios_actualizar_deudas.updated_at',
            )
            ->orderBy('comentarios_actualizar_deudas.created_at', 'desc')
            ->get();

            return response()->json($comentarios);
        } else {
            return response()->json(null);
        }
    }

    public function save(ValidarComentarioActualizarDeuda $request)
    {
        $comentario = ComentarioActualizarDeuda::create($request->validated());

        return Redirect::route('deudas'); //aqui se pueden direccionar ventanas modales
    }
}
