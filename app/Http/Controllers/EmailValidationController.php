<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailValidationController extends Controller
{
    public function validateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        $domain = substr(strrchr($email, "@"), 1);

        // Verificar dominio MX
        $hasMX = checkdnsrr($domain, 'MX');

        // Lista simple de dominios temporales (se puede hacer más grande)
        $temporaryDomains = ['mailinator.com', 'yopmail.com', '10minutemail.com'];
        $isTemporary = in_array($domain, $temporaryDomains);

        return response()->json([
            'email' => $email,
            'valid_format' => true,
            'has_mx_records' => $hasMX,
            'is_temporary' => $isTemporary,
        ]);
    }
}
