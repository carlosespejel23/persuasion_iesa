<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarDeudor;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Deudor;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DeudorController extends Controller
{
    public function index(){
        $deudor = Deudor::all();

        if ($deudor->isEmpty()) {
            $deudor = null;
        }

        return Inertia::render('Deudores/Deudores', [
            'deudor' => $deudor
        ]);
    }

    //Crear un deudor
    public function create(){
        return Inertia::render('Deudores/Create');
    }

    public function save(ValidarDeudor $request){
        $deudor = Deudor::create($request->validated());

        return Redirect::route('deudores');
    }

    //Mostrar los deudores en la lista
    public function show(){
        $userId = auth()->user()->getAuthIdentifier();
        $deudor = DB::table('deudores')
        ->join('users', function(JoinClause $join) use ($userId) {
            $join->on('deudores.usuario_id', '=', 'users.id')
            ->where('users.id', '=', $userId);
        })
        ->select(
            'deudores.id',
            'deudores.usuario_id',
            'deudores.nombre',
            'deudores.apellidoPaterno',
            'deudores.apellidoMaterno',
            'deudores.email',
            'deudores.telefono',
            'deudores.created_at',
            'deudores.updated_at',
        )
        ->orderBy('deudores.created_at', 'desc')
        ->get();

        return response()->json($deudor);
    }

    //Mostrar informacion de un deudor del usuario autenticado
    public function showInfoDeudor($id){
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $deudor = $deudorUsers->first();
            return Inertia::render('Deudores/InfoDeudor', [
                'deudor' => $deudor
            ]);
        } else {
            return Redirect::route('deudores');
        }
    }

    public function showDeudor($id){
        $userId = auth()->user()->getAuthIdentifier();
        $deudorUsers = Deudor::where('usuario_id', $userId)
                            ->where('id', $id)
                            ->get();

        if ($deudorUsers->isNotEmpty()) {
            $deudor = DB::table('deudores')
            ->join('users', function(JoinClause $join) use ($userId, $id) {
                $join->on('deudores.usuario_id', '=', 'users.id')
                ->where('users.id', '=', $userId)
                ->where('deudores.id', '=', $id);
            })
            ->select(
                'deudores.id',
                'deudores.usuario_id',
                'deudores.nombre',
                'deudores.apellidoPaterno',
                'deudores.apellidoMaterno',
                'deudores.email',
                'deudores.telefono',
                'deudores.nacionalidad',
                'deudores.curp',
                'deudores.rfc',
                'deudores.monto_a_pagar',
                'deudores.monto_pagado',
                'deudores.created_at',
            )
            ->orderBy('deudores.created_at', 'desc')
            ->get();

            return response()->json($deudor);
        } else {
            return response()->json(null);
        }
    }

    //Agrega el CURP y RFC del deudor en caso de que en el formulario de agregar deudor haya sido omitido
    public function agregarInfoDeudor(Request $request, $id): RedirectResponse
    {
        //$idUser = auth()->user()->getAuthIdentifier();
        $deudor = Deudor::find($id);
        
        $deudor->fill($request->validate([
            'curp' => ['string', 'max:18'],
            'rfc' => ['string', 'max:13'],
        ]));
        $deudor->save();

        return Redirect::route('deudores');
    }

    //Eliminar un deudor
    public function destroy($id){
        $deudor = Deudor::find($id);
        if ($deudor) {
            $deudor->delete();
        }
    }
}
