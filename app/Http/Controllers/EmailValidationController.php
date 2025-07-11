<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
class EmailValidationController extends Controller
{
 

public function validate(Request $request)
{
    $user = Auth::user();

    if ($user->validations_used >= $user->validations_limit) {
        return response()->json([
            'message' => 'Límite de validaciones alcanzado. Actualiza tu plan.'
        ], 403);
    }

    $request->validate([
        'email' => 'required|email'
    ]);

    $email = $request->input('email');

    // Ejemplo de validación básica
    $hasMX = checkdnsrr(explode('@', $email)[1], 'MX');
    $valid = filter_var($email, FILTER_VALIDATE_EMAIL) && $hasMX;

    // Incrementar uso
    $user->increment('validations_used');

    return response()->json([
        'email' => $email,
        'valido' => $valid
    ]);
}

}
