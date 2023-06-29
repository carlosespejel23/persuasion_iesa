<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagoDeudaRequest;
use App\Http\Requests\ValidarComentarioDeudaPago;
use App\Models\ComentarioDeudaPago;
use App\Models\Deudor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PagoController extends Controller
{
    public function index()
    {
        $deudor = Deudor::all();
        $comentarios = ComentarioDeudaPago::all();

        if ($deudor->isEmpty() && $comentarios->isEmpty()) {
            $deudor = null;
            $comentarios = null;
        }

        return Inertia::render('Pagos/Pagos', [
            'deudor' => $deudor,
            'comentarios' => $comentarios
        ]);
    }

    public function edit($id)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $deudor = $deudorUsers->first();
            return Inertia::render('Pagos/Update', [
                'deudor' => $deudor
            ]);
        } else {
            return Redirect::route('pagos');
        }
    }

    public function update(PagoDeudaRequest $request, $id): RedirectResponse
    {
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $deudor = $deudorUsers->first();
        
            $deudor->fill($request->validated());
            $deudor->save();

            return Redirect::route('pagos.edit', ['id' => $id]);
        } else {
            return Redirect::route('pagos.edit', ['id' => $id]);
        }
    }

    //Comentarios
    public function create($id)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $deudor = $deudorUsers->first();

            return Inertia::render('Pagos/CreateComment', [
                'deudor' => $deudor
            ]);
        } else {
            return Redirect::route('pagos'); //Aqui puede agregar una ventana modal
        }
    }

    public function showComment($id)
    {
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $comentarios = DB::table('comentarios_deudas_pagos')
            ->join('deudores', function ($join) use ($id) {
                $join->on('comentarios_deudas_pagos.deudor_id', '=', 'deudores.id')
                    ->where('deudores.id', '=', $id);
            })
            ->join('users', function ($join) use ($userId) {
                $join->on('comentarios_deudas_pagos.usuario_id', '=', 'users.id')
                    ->where('users.id', '=', $userId);
            })
            ->select(
                'comentarios_deudas_pagos.comentario',
                'comentarios_deudas_pagos.created_at',
                'comentarios_deudas_pagos.updated_at',
            )
            ->orderBy('comentarios_deudas_pagos.created_at', 'desc')
            ->get();

            return response()->json($comentarios);
        } else {
            return response()->json(null);
        }
    }

    public function save(ValidarComentarioDeudaPago $request)
    {
        $comentario = ComentarioDeudaPago::create($request->validated());

        return Redirect::route('pagos'); //aqui se pueden direccionar ventanas modales
    }
}