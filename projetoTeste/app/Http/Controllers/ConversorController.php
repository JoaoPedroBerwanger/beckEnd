<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversorController extends Controller
{
    public function index()
    {
        return view('conversor.index');
    }

    public function converter(Request $request)
    {
        $request->validate(
        [
            'temperatura' => 'required|numeric',
            'tipo' => 'required|in:celsius,fahrenheit',
        ], [
            'temperatura.required' => 'Informe a temperatura.',
            'temperatura.numeric' => 'A temperatura deve ser um número.',
            'tipo.required' => 'Selecione o tipo de conversão.',
            'tipo.in' => 'Tipo de conversão inválido.',
        ]);

        $temp = (float) $request->temperatura;
        $tipo = $request->tipo;

        if ($tipo === 'celsius') 
        {
            $resultado = ($temp * 9 / 5) + 32;
            $de = 'Celsius (°C)';
            $para = 'Fahrenheit (°F)';
        } 
        else 
        {
            $resultado = ($temp - 32) * 5 / 9;
            $de = 'Fahrenheit (°F)';
            $para = 'Celsius (°C)';
        }

        return view('conversor.index', compact('temp', 'tipo', 'resultado', 'de', 'para'));
    }
}
