<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImcController extends Controller
{
    public function index()
    {
        return view('imc.index');
    }

    public function calcular(Request $request)
    {
        $request->validate([
            'peso'   => 'required|numeric|min:1|max:600',
            'altura' => 'required|numeric|min:0.5|max:3',
        ], [
            'peso.required'   => 'Informe o peso.',
            'peso.numeric'    => 'O peso deve ser numérico.',
            'peso.min'        => 'O peso deve ser pelo menos 1 kg.',
            'altura.required' => 'Informe a altura.',
            'altura.numeric'  => 'A altura deve ser numérica.',
            'altura.min'      => 'A altura deve ser pelo menos 0,5 m.',
            'altura.max'      => 'A altura deve ser no máximo 3 m.',
        ]);

        $peso   = (float) $request->peso;
        $altura = (float) $request->altura;
        $imc    = $peso / ($altura * $altura);

        $classificacao = match (true) {
            $imc < 18.5 => ['texto' => 'Abaixo do peso',  'cor' => 'blue'],
            $imc < 25.0 => ['texto' => 'Peso normal',     'cor' => 'green'],
            $imc < 30.0 => ['texto' => 'Sobrepeso',       'cor' => 'yellow'],
            $imc < 35.0 => ['texto' => 'Obesidade Grau I','cor' => 'orange'],
            $imc < 40.0 => ['texto' => 'Obesidade Grau II','cor' => 'red'],
            default     => ['texto' => 'Obesidade Grau III (Mórbida)', 'cor' => 'red'],
        };

        return view('imc.index', compact('peso', 'altura', 'imc', 'classificacao'));
    }
}
