<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    public function storePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:3120'],
        ]);

        $user = $request->user();

        // Guardar la nueva imagen solo si el usuario proporciona una imagen personalizada
        if ($request->hasFile('profile_image')) {
            // Obtener el nombre original de la imagen de perfil del usuario (sin la ruta)
            $currentFileName = basename($user->profile_image);

            // Generar el nuevo nombre de archivo para la nueva imagen de perfil
            $newFileName = 'profile_' . uniqid() . '.' . $request->file('profile_image')->getClientOriginalExtension();

            // Eliminar la imagen anterior solo si el nombre de archivo es diferente a "default"
            if ($currentFileName !== 'default.jpg') {
                Storage::disk('public')->delete('profiles/' . $currentFileName);
            }

            // Guardar la nueva imagen con el nuevo nombre de archivo
            $path = $request->file('profile_image')->storeAs('profiles', $newFileName, 'public');

            // Actualizar el campo de la imagen de perfil del usuario con la nueva ruta
            $user->profile_image = '/storage/' . $path;
            $user->save();
        }

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
