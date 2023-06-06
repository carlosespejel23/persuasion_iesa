<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidarDeudor;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Deudor;

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

    public function create(){
        return Inertia::render('Deudores/Create');
    }

    public function save(ValidarDeudor $request){
        $deudor = Deudor::create($request->validated());

        return Redirect::route('deudores');
    }

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

    public function destroy($id){
        $deudor = Deudor::find($id);
        if ($deudor) {
            $deudor->delete();
        }
    }
}
