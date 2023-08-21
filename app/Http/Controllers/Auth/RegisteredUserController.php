<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoPaterno' => 'required|string|max:255',
            'apellidoMaterno' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'fecha_de_nacimiento' => 'required|date',
            'nacionalidad' => 'required|string|max:255',
            'acepto_contrato' => 'required|boolean',
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $defaultImagePath = 'profiles/default.jpg';

        // Generar el nuevo nombre de archivo para la imagen de perfil del usuario
        $extension = pathinfo($defaultImagePath, PATHINFO_EXTENSION);
        $newImagePath = "profiles/default.{$extension}";

        // Crear el usuario con la imagen de perfil por defecto
        $user = User::create([
            'nombre' => $request->nombre,
            'apellidoPaterno' => $request->apellidoPaterno,
            'apellidoMaterno' => $request->apellidoMaterno,
            'telefono' => $request->telefono,
            'fecha_de_nacimiento' => $request->fecha_de_nacimiento,
            'nacionalidad' => $request->nacionalidad,
            'acepto_contrato' => $request->acepto_contrato,
            'email' => $request->email,
            'profile_image' => Storage::url($defaultImagePath),
            'password' => Hash::make($request->password),
        ]);

        // Copiar la imagen default al nuevo perfil del usuario
        Storage::copy($defaultImagePath, $newImagePath);

        // Actualizar el campo de la imagen de perfil del usuario con la nueva ruta
        $user->profile_image = Storage::url($newImagePath);
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
