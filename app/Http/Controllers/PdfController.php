<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $request->validate([
            'html' => 'required|string'
        ]);

        $html = $request->input('html');

        // Generar PDF
     $pdf = PDF::loadHTML($html);


        // Retornar PDF para descargar o mostrar inline
        return $pdf->stream('documento.pdf');
    }

}
