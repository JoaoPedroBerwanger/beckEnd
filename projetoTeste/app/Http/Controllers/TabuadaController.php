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
        $request->validate(['numero' => 'required|integer|min:0|max:20',], 
        [
            'numero.required' => 'Informe um número.',
            'numero.integer' => 'O número deve ser inteiro.',
            'numero.min' => 'Informe um número de 0 a 20.',
            'numero.max' => 'Informe um número de 0 a 20.',
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
