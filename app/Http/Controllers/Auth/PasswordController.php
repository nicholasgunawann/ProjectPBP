<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required'],
        ]);

        // Cek password lama
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->with('error', 'Password lama salah!');
        }

        // Cek password baru dan konfirmasi sama
        if ($request->password !== $request->password_confirmation) {
            return back()->with('error', 'Password baru dan konfirmasi tidak sama!');
        }

        // Update password
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}
