<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TabuadaController extends Controller
{
    public function index()
    {
        return view('tabuada.index');
    }

    public function calcular(Request $request)
    {
        $request->validate([
            'numero' => 'required|integer|min:0|max:20',
        ], [
            'numero.required' => 'Informe um número.',
            'numero.integer'  => 'O valor deve ser um número inteiro.',
            'numero.min'      => 'O número deve ser pelo menos 0.',
            'numero.max'      => 'O número deve ser no máximo 20.',
        ]);

        $numero = (int) $request->numero;

        $tabuada = [];
        for ($i = 1; $i <= 10; $i++) {
            $tabuada[$i] = $numero * $i;
        }

        $fatorial = 1;
        for ($i = 1; $i <= $numero; $i++) {
            $fatorial *= $i;
        }

        return view('tabuada.index', compact('numero', 'tabuada', 'fatorial'));
    }
}
