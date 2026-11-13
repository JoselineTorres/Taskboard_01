<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    // POST /api/login -> 201 con el token
    public function login(Request $request)
    {
        // Si falta un dato, Laravel responde 422 en JSON solo
        $datos = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required'],
            'dispositivo' => ['required', 'max:100'],
        ]);

        $user = User::where('email', $datos['email'])->first();

        // Mensaje genérico: no revela si el correo existe
        if (! $user || ! Hash::check($datos['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden.',
            ]);
        }

        // Guarda el hash del token en personal_access_tokens
        $token = $user->createToken($datos['dispositivo']);

        return response()->json([
            'token' => $token->plainTextToken, // solo existe en ESTA respuesta
            'tipo'  => 'Bearer',
        ], 201);
    }

    // GET /api/yo -> el dueño del token
    public function yo(Request $request)
    {
        return $request->user()->only('id', 'name', 'email');
    }

    // POST /api/logout -> 204, borra solo el token usado en esta petición
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

    // ---------- RETO (opcional) ----------

    // GET /api/tokens -> dispositivos con sesión abierta
    public function tokens(Request $request)
    {
        // Se piden solo estas columnas: NUNCA se expone el hash (columna token)
        $tokens = $request->user()
            ->tokens()
            ->get(['id', 'name', 'created_at', 'last_used_at']);

        return response()->json(['data' => $tokens]);
    }

    // DELETE /api/tokens/{id} -> cierra la sesión de un dispositivo concreto
    public function cerrarDispositivo(Request $request, int $id)
    {
        // Se busca SOLO entre los tokens del usuario: si es de otro, da 404
        $token = $request->user()->tokens()->where('id', $id)->firstOrFail();

        $token->delete();

        return response()->noContent();
    }
}