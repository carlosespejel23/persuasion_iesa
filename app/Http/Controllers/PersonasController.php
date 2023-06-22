<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PersonasController extends Controller
{
    public function index() {
        $user = User::all();

        if ($user->isEmpty()) {
            $user = null;
        }

        return Inertia::render('Personas/Personas', [
            'user' => $user
        ]);
    }

    public function show() {
        $userId = auth()->user()->getAuthIdentifier();
        $user = DB::table('users')
        ->select(
            'users.nombre',
            'users.apellidoPaterno',
            'users.apellidoMaterno',
        )
        ->where('users.id', '!=', $userId)
        ->orderBy('users.created_at', 'desc')
        ->get();

        return response()->json($user);
    }
}
