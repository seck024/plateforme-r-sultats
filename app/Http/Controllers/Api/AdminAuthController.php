<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        // session
        session(['admin_id' => $admin->id]);

        return response()->json([
            'message' => 'Connexion réussie',
            'admin' => $admin
        ]);
    }

    public function me()
    {
        if (!session()->has('admin_id')) {
            return response()->json(['message' => 'Non connecté'], 401);
        }

        return Admin::find(session('admin_id'));
    }

    public function logout()
    {
        session()->forget('admin_id');

        return response()->json([
            'message' => 'Déconnexion'
        ]);
    }
}
