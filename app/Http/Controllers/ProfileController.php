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
            'profile_image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:5120'],
        ]);

        $user = $request->user();

        // Eliminar imagen anterior si existe
        if ($user->profile_image) {
            // Obtener el nombre de archivo actual
            $currentFileName = basename($user->profile_image);
            
            // Eliminar la imagen anterior
            Storage::disk('public')->delete('profiles/' . $currentFileName);
        }

        // Guardar la nueva imagen
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $fileName = $profileImage->getClientOriginalName();
            $path = $profileImage->storeAs('profiles', $fileName, 'public');
            $user->profile_image = '/storage/' . $path; // Agregar '/storage/' al inicio de la ruta
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
