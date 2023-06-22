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
        $deudor = Deudor::find($id);

        return Inertia::render('Pagos/Update', [
            'deudor' => $deudor
        ]);
    }

    public function update(PagoDeudaRequest $request, $id): RedirectResponse
    {
        $deudor = Deudor::find($id);
        
        $deudor->fill($request->validated());
        $deudor->save();

        return Redirect::route('pagos.edit', ['id' => $id]);
    }

    //Comentarios
    public function create($id)
    {
        $deudor = Deudor::find($id);

        return Inertia::render('Pagos/CreateComment', [
            'deudor' => $deudor
        ]);
    }

    public function showComment($id)
    {
        $userId = auth()->user()->getAuthIdentifier();
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
    }

    public function save(ValidarComentarioDeudaPago $request)
    {
        $comentario = ComentarioDeudaPago::create($request->validated());

        return Redirect::route('pagos'); //aqui se pueden direccionar ventanas modales
    }
}